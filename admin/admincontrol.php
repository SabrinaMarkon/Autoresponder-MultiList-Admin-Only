<?php
if(!isset($_SESSION))
{
session_start();
}
include "../incs/db.php";
if ($_POST["loginusernameadmin"])
{
$_SESSION["siteadminusername"] = $_POST["siteadminusername"];
$_SESSION["siteadminpassword"] = $_POST["siteadminpassword"];
}
	if(($_SESSION["siteadminusername"] != $adminuserid) or ($_SESSION["siteadminpassword"] != $adminpassword))
	{
	unset($_SESSION["siteadminusername"]);
	unset($_SESSION["siteadminpassword"]);
	include "../header.php";
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;"><?php echo $title ?> ADMIN LOGIN</div></td></tr>
	<tr><td colspan="2" align="center"><br><font color="#FF0000" size="3" face="Verdana"><b>INCORRECT LOGIN</b></font></td></tr>
	<tr><td align="right"><form action="controlpanel.php" method="post"><br>ADMIN USERNAME: </td><td><br><input type="text" name="siteadminusername" class="typein"" maxlength="16" size="14"></td></tr><tr><td align="right">ADMIN PASSWORD: </td><td><input type="password" name="siteadminpassword" class="typein" maxlength="16" size="14"></td></tr><tr><td colspan="2" align="center"><br><input type="submit" value="LOGIN" class="sendit"></form>
	</td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "../footer.php";
	exit;
	}
?>