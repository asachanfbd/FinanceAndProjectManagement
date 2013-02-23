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
                            <?php
                                 echo "<b>".$newsupdates->gettitle($_GET['pagename'])."</b>";
                                 echo "<p>".$newsupdates->getcontent($_GET['pagename'])."</p>";
                             ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="smallfont"><br>Delete news here.</td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Delete" name="fullnamesubmitb" id="fullnamesubmitb"><input onclick="cancelprofileedit(this)" type="button" value="Cancel" class="cancelsetting"></td>
                    </tr>
                </table>
         </form>
<?php
    }
 ?>