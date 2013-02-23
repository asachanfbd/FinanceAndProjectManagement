            <?php
            $data1 = '<form action="controller.php" method="post" class="ajaxsubmitform">
            <input type="hidden" value="companyname" name="page" id="page">
            <input type="hidden" value="addnew" name="type" id="type">
            <input type="hidden" value="" name="ajaxrequest" id="ajaxrequest">
                <table width="100%">
                    <tr>
                        <td><input type="text" placeholder="Enter New Name" name="title" id="title" style="width: 95%; border: 1px solid #ccc; padding: 3px 5px; "></td>
                    </tr>
                    <tr>
                        <td><textarea name="body" id="body" class="mceEditor" style="width: 98%; height: 300px;"></textarea></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Add Name"></td>
                    </tr>
                </table>
            </form>';
            
        $body .= $view->getcmsbox('Add New Name', $data1, 'Write the name in header and meaning+description in body part.');
        $rows = array();
        $re = $db->querydb("SELECT * FROM companyname");
        $status = 'read';
        if($re->num_rows){
            while($ro = $re->fetch_object()){
                $rows[] = $view->getcmsrow($id, $ro->id, $ro->title, 'Added '.getRelativeTime($ro->added), 'Open', $status);
            }
            
        }else{
            $rows[] = 'No company exists to followup.';
        }
        
        $body .= $view->getcmsbox('Current Names', $rows, 'Click on the above name to see complete discussion.');
    ?>
