<?php
include "admincontrol.php";
$action = $_POST["action"];
if ($action == "send")
{
$fromfield = $_POST['fromfield'];
$subjectfield = $_POST['subjectfield'];
$messagefield = $_POST['messagefield'];
$prospectgroups = $_POST['prospectgroups'];
if(!$fromfield)
{
$error .= "<li>Please return and enter your name to appear in the from field of your message.</li>";
}
if(!$subjectfield)
{
$error .= "<li>Please return and enter the subject of your email.</li>";
}
if(!$messagefield)
{
$error .= "<li>Please return and enter a message body for your email.</li>";
}
if(empty($prospectgroups))
{
$error .= "<li>Please return and select at least one prospect group to mail to.</li>";
}
if(!$error == "")
	{
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
<tr><td colspan="2"><br>Please return to the form and correct the following problems:<br>
<ul><?php echo $error ?></ul>
</td></tr>
<tr><td align="center" colspan="2"><br>
<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
</td></tr>

<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
	}

$buildquery = "where ";
foreach ($prospectgroups as $checked)
{
$buildquery = $buildquery . "prospectgroup=\"$checked\" or ";
}
$buildquery = substr($buildquery, 0, -4); 

$q = "select * from prospects " . $buildquery . " order by email";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
	{
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">ERROR</div></td></tr>
<tr><td colspan="2" align="center"><br>Sorry there are currently no email addresses to send to in the prospect groups specified!
</td></tr>
<tr><td align="center" colspan="2"><br>
<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
</td></tr>

<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
	}
if ($rows > 0)
	{
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">SENDING YOUR MESSAGE PLEASE WAIT . . .</div></td></tr>
<?php
	while ($rowz = mysql_fetch_array($r))
		{
		$id = $rowz["id"];
		$email = $rowz["email"];
		$firstname = $rowz["firstname"];
		$lastname = $rowz["lastname"];
		$fullname = $firstname . " " . $lastname;
		$prospectgroup = $rowz["prospectgroup"];

$removelinkhtml = "<br><br>" . $disclaimer . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $email . ">" . $domain . "/remove.php?r=" . $email . "</a><br>";

$to = $email;
$subjectfield = ereg_replace ("~FIRSTNAME~", $firstname, $subjectfield);
$subjectfield = ereg_replace ("~LASTNAME~", $lastname, $subjectfield);
$subjectfield = stripslashes($subjectfield);
$from = ereg_replace ("~FIRSTNAME~", $firstname, $fromfield);
$from = ereg_replace ("~LASTNAME~", $lastname, $fromfield);
$from = stripslashes($from);
$messagefield = ereg_replace ("~FIRSTNAME~", $firstname, $messagefield);
$messagefield = ereg_replace ("~LASTNAME~", $lastname, $messagefield);
$messagefield = stripslashes($messagefield);

$message = $messagefield . $removelinkhtml;

$headers = "From: $from <$autoresponderemail>\n" .
           "MIME-Version: 1.0\n" .
           "Content-Type: text/html; charset=windows-1252\n" .
           "X-Mailer: PHP - $title\n" .
            "Return-Path: $autoresponderemail\n";

@mail ($to, $subjectfield, $message, $headers, "-f" . $autoresponderemail);
echo "<tr><td colspan=2 align=center><br>Message sent to " . $fullname . " at email address " . $email . " - Prospect Group " . $prospectgroup . "</td></tr>";
		}
?>
<tr><td align="center" colspan="2"><br>SEND COMPLETED!</td></tr>
<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
	}
} # if ($action == "send")
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	extended_valid_elements : "a[href|target|name],font[face|size|color|style],span[class|align|style]"
});
</script>
<!-- /tinyMCE --> 
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">SEND A MESSAGE TO ALL LEADS IN A PROSPECT LIST</div></td></tr>

<?php
$pq = "select * from prospectgroups order by prospectgroupname";
$pr = mysql_query($pq);
$prows = mysql_num_rows($pr);
if ($prows < 1)
{
?>
<tr><td colspan="2" align="center"><br>Please <a href="prospectlist.php">Click Here</a> to create at least one prospect group first before you are able to send mail.</td></tr>
<?php
include "../footer.php";
exit;
}
?>

<tr><td colspan="2"><br>You may use the personalization variables ~FIRSTNAME~ or ~LASTNAME~ anywhere in your subject, from field, or message body, typed EXACTLY as shown (case sensitive)</td></tr>
<tr><td colspan="2" align="center" ><form action="contactsend.php" method="post" name="theform"><br>Your Name That Should Appear In The From Field In The Recipient Inboxes: </td></tr><tr><td align="center"><input type="text" class="typein" name="fromfield" maxlength="255" size="95"></td></tr>
<tr><td colspan="2" align="center" ><br>Subject Of Your Email:</td></tr><tr><td align="center"><input type="text" class="typein" name="subjectfield" maxlength="255" size="95"></td></tr><tr><td colspan="2" align="center" ><br>Your Message Body:</td></tr><tr><td colspan="2" align="center"><textarea name="messagefield" maxlength="50000" rows="15" cols="72"></textarea></td></tr>
<tr><td colspan="2" align="center" ><br>Prospect Groups To Send To:</td></tr><tr><td align="center"><br>
<div style="width: 200px; text-align: left;">
<?php
while ($prowz = mysql_fetch_array($pr))
{
$pid = $prowz["id"];
$prospectgroupname = $prowz["prospectgroupname"];
?>
<input type="checkbox" name="prospectgroups[]" value="<?php echo $prospectgroupname ?>">&nbsp;<?php echo $prospectgroupname ?><br>
<?php
}
?>
</div>
</td></tr>

<tr><td colspan="2" align="center"><br><br><input type="hidden" name="action" value="send"><input type="submit" value="SEND EMAIL" class="sendit" style="width: 150px;"></form></td></tr>

<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table><br><br>&nbsp;
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
?>