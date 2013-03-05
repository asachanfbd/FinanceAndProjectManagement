<?php
                $rows = array();
                $settings = array(
                            'fullname'  =>  array(
                                        'name'      =>  'Name: '.$user->getfullname(),
                                        'content'   =>  'Updated '.getRelativeTime($user->getpasswordtime()),
                                        'edit'      =>  'Edit'
                            ),
                            'email'     =>  array(
                                        'name'      =>  'E-Mail: '.$user->getemail(),
                                        'content'   =>  'Updated '.getRelativeTime($user->getpasswordtime()),
                                        'edit'      =>  'Edit'
                            ),
                            'password'  =>  array(
                                        'name'      =>  'Password',
                                        'content'   =>  'Updated '.getRelativeTime($user->getpasswordtime()),
                                        'edit'      =>  'Edit'
                            )
                );
                if($user->getid() == 'superadmin'){
                        $settings['users'] =  array(
                                        'name'      =>  'Users',
                                        'content'   =>  'There are '.count($user->getusers()).' registered user'.plural(count($user->getusers())),
                                        'edit'      =>  'Edit'
                            );
                }
                foreach($settings as $k=>$v){
                    $rows[] = $view->getcmsrow($id, $k, $v['name'], $v['content']);
                }
                $body .= $view->getcmsbox('Profile Information', $rows, 'Click on the above settings to edit.');
?>