<?php 
include "../incs/db.php";
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;"><?php echo $title ?> ADMIN LOGIN</div></td></tr>
<tr><td align="right"><form action="controlpanel.php" method="post"><br>ADMIN USERNAME: </td><td><input type="text" name="siteadminusername" class="typein" maxlength="16" size="14" value="Admin"></td></tr><tr><td align="right">ADMIN PASSWORD: </td><td><input type="password" name="siteadminpassword" class="typein" maxlength="16" size="14" value="admin"></td></tr><tr><td colspan="2" align="center"><br><input type="submit" value="LOGIN" class="sendit"></form></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
?>