<?php
  class stats{
      
      public function getBrowser(){
            if(!isset($_COOKIE['bid'])){
                $t = profiler::add("creating session");
                $values['BROWSER_ID'] = uniqid();
                $values['HTTP_USER_AGENT'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
                $values['REMOTE_ADDR'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
                $values['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct';
                /**
                * ----------------------------------------------------------------------------------------------------------
                * check if user agent is already present in db. placed here bcoz - query(inser) below would add a new record with the same ua.
                * ---------------------------------------------------------------------------------------------------------
                */
                $ua = db::querydb('SELECT * FROM raw_stats WHERE HTTP_USER_AGENT = "'.$_SERVER['HTTP_USER_AGENT'].'"');
                /**
                * ---------------------------------------------------------------------------------------------------------
                */
                db::insert('raw_stats', $values);
                
                if(!setcookie('bid', $values['BROWSER_ID'], (time()+(60*60*24*365*2)), '/')){
                    error::report('#runtime', 'Cookie can not be set', 'while setting browser id cookie', '', '');
                }
                
                if($ua->num_rows){
                    $bid = $ua->fetch_object()->BROWSER_ID;
                    $re = db::querydb('SELECT * FROM refined_stats WHERE BROWSER_ID = "'.$bid.'"');
                    if($re->num_rows){
                        $ua = $re->fetch_object();
                        if($ua->agent_name != "" || $ua->agent_type != "" || $ua->os_name != ""){
                            $value['agent_name'] = $ua->agent_name;
                            $value['agent_type'] = $ua->agent_type;
                            $value['os_name'] = $ua->os_name;
                            $value['BROWSER_ID'] = $values['BROWSER_ID'];
                            db::insert('refined_stats', $value);
                            profiler::add("Session created and refined browser data (from self db)", $t);
                            return $value;
                        }else{
                            profiler::add("Session created! now refining browser", $t);
                            return self::refineBrowser($values['BROWSER_ID']);
                        }
                    }
                }else{
                    return self::refineBrowser($values['BROWSER_ID']);
                }
            }else{
                $re = db::querydb('SELECT * FROM refined_stats WHERE BROWSER_ID = "'.$_COOKIE['bid'].'"');
                if($re->num_rows == 0){
                    setcookie('bid', '', 123);
                    setcookie('sessionid', '', 123);
                    header("location: index_beta.php");
                }
                $ua = $re->fetch_object();
                $values['BROWSER_ID'] = $_COOKIE['bid'];
                $values['agent_name'] = $ua->agent_name;
                $values['agent_type'] = $ua->agent_type;
                $values['os_name'] = $ua->os_name;
                return $values;
            }
      }
      
      private function refineBrowser($bid){
            $t = profiler::add("Refining browser");
            $url = "http://www.useragentstring.com/?uas=".urlencode($_SERVER['HTTP_USER_AGENT'])."&getJSON=agent_name-agent_type-os_name";
            if(($fp=fopen($url, 'rb'))!=null){
                $json = stream_get_contents($fp);
                fclose($fp);
            }
            if($result = json_decode($json, true)){
                $values['agent_name'] = isset($result['agent_name']) ? $result['agent_name'] : 'unavailable';
                $values['agent_type'] = isset($result['agent_type']) ? $result['agent_type'] : 'unavailable';
                $values['os_name'] = isset($result['os_name']) ? $result['os_name'] : 'unavailable';
                $value = $values;
                $values['BROWSER_ID'] = $bid;
                db::insert('refined_stats', $values);
                profiler::add("Refined browser data", $t);
                return $values;
            }
      }
      
      public function getMaps(){
            // Loading of google map of my location.
            $url = 'https://www.google.com/latitude/apps/badge/api?user=3797108084117613008&type=json';
            if(($fp=fopen($url, 'rb'))!=null)
            {
                $json = stream_get_contents($fp);
                fclose($fp);
            }
            $location = json_decode($json, true);
            $latlong = $location['features'][0]['geometry']['coordinates'];
            $center = $latlong[1].", ".$latlong[0];
            $zoom = 10;
            return "http://maps.googleapis.com/maps/api/staticmap?maptype=hybrid&markers=color:blue|".$center."&size=640x300&sensor=false&scale=2&zoom=".$zoom;
            // $url now contains map marked with my location
      }
      
      public function recordSession($bid, $type="keep-alive"){
          if(isset($_COOKIE['sessionid'])){
              $values['requestid'] = $_COOKIE['sessionid'];
              $values['BROWSER_ID'] = $bid;
              $values['request_type'] = $type;
              db::insert('visitors', $values);
          }else{
              $sessionid = uniqid();
              if(!setcookie('sessionid', $sessionid)){
                    error::report('#runtime', 'Cookie can not be set', 'while setting session id cookie', '', '');
              }
              $values['requestid'] = $sessionid;
              $values['BROWSER_ID'] = $bid;
              $values['request_type'] = $type;
              db::insert('visitors', $values);
          }
      }
      
      public function ipToLocation($ip){
          $t = profiler::add("checking for data in own db");
          $values = array(
                    'cityName'      => 'unavailable',
                    'regionName'    => 'unavailable',
                    'countryName'   => 'unavailable',
                    'countryCode'   => 'unavailable',
                    'zipCode'       => 'unavailable',
                    'latitude'      => 'unavailable',
                    'longitude'     => 'unavailable',
                    'timeZone'      => 'unavailable'
          );
          $q = 'SELECT refined_stats.cityName, refined_stats.regionName, refined_stats.countryName, refined_stats.countryCode, refined_stats.zipCode, refined_stats.latitude, refined_stats.longitude, refined_stats.timeZone FROM raw_stats, refined_stats WHERE raw_stats.REMOTE_ADDR = "'.$ip.'" AND raw_stats.BROWSER_ID = refined_stats.BROWSER_ID AND raw_stats.added >= '.(time() - (60*60*24*10)).' LIMIT 1';
          $re = db::querydb($q);
          if($re->num_rows){
              $t = profiler::add("data found in own db", $t);
              $values = $re->fetch_assoc();
              if($values['countryName'] == ""){
                  $t = profiler::add("data found in own db but its empty", $t);
                  $values = self::ipdb($ip);
              }
          }else{
              $values = self::ipdb($ip);
          }
          return $values;
      }
      
      private function ipdb($ip){
          $t = profiler::add("Calling IP Info DB");
          $url = 'http://api.ipinfodb.com/v3/ip-city/?key=0b6b8fd8799b4f47ecb7988c3d48bac070e65407ec0e80f8471c0e22b5887e59&ip='.$ip.'&format=json';
          if(($fp=fopen($url, 'rb'))!=null){
             $json = stream_get_contents($fp);
             fclose($fp);
          }
          $t = profiler::add("ipinfodb returened now refining", $t);
          if($result = json_decode($json, true)){
              if(isset($result['cityName'])){ $values['cityName'] = $result['cityName'];}
              if(isset($result['regionName'])){ $values['regionName'] = $result['regionName'];}
              if(isset($result['countryName'])){ $values['countryName'] = $result['countryName'];}
              if(isset($result['countryCode'])){ $values['countryCode'] = $result['countryCode'];}
              if(isset($result['zipCode'])){ $values['zipCode'] = $result['zipCode'];}
              if(isset($result['latitude'])){ $values['latitude'] = $result['latitude'];}
              if(isset($result['longitude'])){ $values['longitude'] = $result['longitude'];}
              if(isset($result['timeZone'])){ $values['timeZone'] = $result['timeZone'];}
          }
          return $values;
      }
  }
?>
