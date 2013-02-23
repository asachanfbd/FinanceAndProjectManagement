<?php
    if(isset($_GET['pagename'])){
?>
            <form action="controller.php" method="post" class="ajaxsubmitform">
            <input type="hidden" value="pages" name="page" id="page">
            <input type="hidden" value="<?php echo $_GET['pagename']; ?>" name="type" id="type">
            <input type="hidden" value="" name="ajaxrequest" id="ajaxrequest">
                <table width="100%" class="listnerbox">
                    <tr>
                        <td colspan="3" class="smallfont">Edit the content here to appear in your home page.</td>
                    </tr>
                    <tr>
                        <td>Title</td><td>:</td><td><input type="text" value="<?php echo $contentpages->gettitle($_GET['pagename']); ?>" name="pagetitle" id="pagetitle"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                        Page Content
                        <textarea class="mceEditor" style="width: 90%; height: 400px;" name="pagecontent" id="pagecontent"><?php echo $contentpages->getcontent($_GET['pagename']); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                        S.E.O Tags
                        <textarea style="width: 90%; height: 100px;" name="pageseotags" id="pageseotags"><?php echo $contentpages->getseotags($_GET['pagename']); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" value="Save" name="fullnamesubmitb" id="fullnamesubmitb"><input onclick="cancelprofileedit(this)" type="button" value="Cancel" class="cancelsetting">
                    </tr>
                </table>
            </form>
<?php
    }
 ?>