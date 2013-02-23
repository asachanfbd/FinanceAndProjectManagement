<?php
    if(isset($_GET['pagename'])){
?>
         <form action="controller.php" method="post" class="ajaxsubmitform">
            <input type="hidden" value="<?php echo $_GET['page']; ?>" name="page" id="page">
            <input type="hidden" value="<?php echo $_GET['pagename']; ?>" name="type" id="type">
            <input type="hidden" value="" name="ajaxrequest" id="ajaxrequest">
                <table width="100%" class="listnerbox">
                    <tr>
                        <td>
                            <table>
                            <?php
                                $re = $enquiry->getenquiry($_GET['pagename']);
                                if($re){
                                    echo "<tr><td>Email</td><td>:</td><td>".$re->email."</td></tr>";
                                    echo "<tr><td>Phone</td><td>:</td><td>".$re->phone."</td></tr>";
                                    echo "<tr><td>Service</td><td>:</td><td>".$re->service."</td></tr>";
                                    echo "<tr><td>Message</td><td>:</td><td>".$re->message."</td></tr>";
                                }
                            ?>
                            </table>
                        </td>
                        <td valign="top">
                            <input type="button" value="Delete" onclick="deleteenquiry(this, '<?php echo $_GET['pagename']; ?>')">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="smallfont"><br>Enquiry Follow ups:</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;" class="controllerbox" colspan="2">
                        <?php
                             $re = $db->querydb("SELECT * FROM enquiryremarks WHERE enqid = '".$_GET['pagename']."' ORDER BY added ASC");
                             if($re->num_rows){
                                 while($ro = $re->fetch_object()){
                                     echo '
                             <div class="boxslip">
                                <div class="left boxtitleslip">
                                    <div>'.$user->getfirstname($ro->addedby).'</div>
                                </div>
                                <div class="right boxtitleslip">
                                    <div>'.getRelativeTime($ro->added).'</div>
                                </div>
                                <div class="boxslipbody left">
                                    <div>'.$ro->msg.'</div>
                                </div>
                            </div>';
                                 }
                             }
                         ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text" placeholder="Enter your remarks here" name="msg" style="width: 90%;" id="msg"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Save" name="fullnamesubmitb" id="fullnamesubmitb"><input onclick="cancelprofileedit(this)" type="button" value="Cancel" class="cancelsetting"></td>
                    </tr>
                </table>
         </form>
<?php
    }
 ?>