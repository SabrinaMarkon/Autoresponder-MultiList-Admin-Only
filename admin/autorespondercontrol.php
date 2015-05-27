<?php
include "admincontrol.php";
$action = $_POST["action"];
if ($action == "savesettings")
{
$newadminuser = $_POST["newadminuser"];
$newadminpass = $_POST["newadminpass"];
$newwebmasteremail = $_POST["newwebmasteremail"];
$newautoresponderemail = $_POST["newautoresponderemail"];
$newredirecturl = $_POST["newredirecturl"];
$newdisclaimer = $_POST["newdisclaimer"];
$newdisclaimer = stripslashes($newdisclaimer);
$newdisclaimer = str_replace("\\","",$newdisclaimer);
$newdisclaimerimports = $_POST["newdisclaimerimports"];
$newdisclaimerimports = stripslashes($newdisclaimerimports);
$newdisclaimerimports = str_replace("\\","",$newdisclaimerimports);
$newdomain = $_POST["newdomain"];
$newtitle = $_POST["newtitle"];
if(!$newadminuser)
{
$error .= "<li>Please return and enter a username to login to your admin area.</li>";
}
if(!$newadminpass)
{
$error .= "<li>Please return and enter a password to login to your admin area.</li>";
}
if(!$newdomain)
{
$error .= "<li>Please return and enter your website url.</li>";
}
if(!$newtitle)
{
$error .= "<li>Please return and enter a name for your website.</li>";
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
$q = "update admin set username=\"$newadminuser\",password=\"$newadminpass\",webmasteremail=\"$newwebmasteremail\",autoresponderemail=\"$newautoresponderemail\",redirecturl=\"$newredirecturl\",disclaimer=\"$newdisclaimer\",disclaimerimports=\"$newdisclaimerimports\",domain=\"$newdomain\",title=\"$newtitle\"";
$r = mysql_query($q);
$siteadminusername = $newadminuser;
$siteadminpassword = $newadminpass;
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">YOUR SETTINGS WERE SAVED!</div></td></tr>
<tr><td align="center"><br><a href="autorespondercontrol.php">BACK TO AUTORESPONDER MESSAGES ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "savesettings")
################################################################
if ($action == "addautoresponder")
{
$newautorespondertitle = $_POST["newautorespondertitle"];
$newautoresponderfromfield = $_POST["newautoresponderfromfield"];
$newautorespondersubject = $_POST["newautorespondersubject"];
$newautorespondersubject = addslashes($newautorespondersubject);
$newautorespondermessage = $_POST["newautorespondermessage"];
$newautorespondermessage = addslashes($newautorespondermessage);
$newprospectgroups = $_POST["newprospectgroups"];
$newautoresponderdays = $_POST["newautoresponderdays"];
if(!$newautoresponderfromfield)
{
$newautoresponderfromfield = $title;
}
if(!$newautorespondertitle)
{
$error .= "<li>Please return and enter a name for your campaign. It is possible to use the same name for all campaigns of a certain type (ie. ones will multiple follow up emails).</li>";
}
if(!$newautorespondersubject)
{
$error .= "<li>Please return and enter the subject of your email.</li>";
}
if(!$newautorespondermessage)
{
$error .= "<li>Please return and enter a message body for your email.</li>";
}
if(empty($newprospectgroups))
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
$sendtoprospectgroups = "";
foreach ($newprospectgroups as $prospects)
	{
	$sendtoprospectgroups = $sendtoprospectgroups . "~" . $prospects;	
	}
$q = "insert into autoresponders (autorespondertitle,autorespondermessage,autorespondersubject,autoresponderfromfield,autoresponderdays,sendtoprospectgroups) values (\"$newautorespondertitle\",\"$newautorespondermessage\",\"$newautorespondersubject\",\"$newautoresponderfromfield\",\"$newautoresponderdays\",\"$sendtoprospectgroups\")";
$r = mysql_query($q);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">YOUR NEW AUTORESPONDER MESSAGE WAS CREATED!</div></td></tr>
<tr><td align="center"><br><a href="autorespondercontrol.php">BACK TO AUTORESPONDER MESSAGES ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "addautoresponder")
################################################################
if ($action == "saveautoresponder")
{
$saveid = $_POST["saveid"];
$saveautorespondertitle = $_POST["saveautorespondertitle"];
$saveautoresponderfromfield = $_POST["saveautoresponderfromfield"];
$saveautorespondersubject = $_POST["saveautorespondersubject"];
$saveautorespondersubject = addslashes($saveautorespondersubject);
$saveautorespondermessage = $_POST["saveautorespondermessage"];
$saveautorespondermessage = addslashes($saveautorespondermessage);
$saveprospectgroups = $_POST["saveprospectgroups"];
$saveautoresponderdays = $_POST["saveautoresponderdays"];
if(!$saveautoresponderfromfield)
{
$saveautoresponderfromfield = $title;
}
if(!$saveautorespondertitle)
{
$error .= "<li>Please return and enter a name for your campaign. It is possible to use the same name for all campaigns of a certain type (ie. ones will multiple follow up emails).</li>";
}
if(!$saveautorespondersubject)
{
$error .= "<li>Please return and enter the subject of your email.</li>";
}
if(!$saveautorespondermessage)
{
$error .= "<li>Please return and enter a message body for your email.</li>";
}
if(empty($saveprospectgroups))
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
$sendtoprospectgroups = "";
foreach ($saveprospectgroups as $prospects)
	{
	$sendtoprospectgroups = $sendtoprospectgroups . "~" . $prospects;	
	}
$q = "update autoresponders set autorespondertitle=\"$saveautorespondertitle\",autorespondermessage=\"$saveautorespondermessage\",autorespondersubject=\"$saveautorespondersubject\",autoresponderfromfield=\"$saveautoresponderfromfield\",autoresponderdays=\"$saveautoresponderdays\",sendtoprospectgroups=\"$sendtoprospectgroups\" where id=\"$saveid\"";
$r = mysql_query($q);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">THE AUTORESPONDER MESSAGE WAS SAVED!</div></td></tr>
<tr><td align="center"><br><a href="autorespondercontrol.php">BACK TO AUTORESPONDER MESSAGES ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "saveautoresponder")
################################################################
if ($action == "deleteautoresponder")
{
$deleteid = $_POST["deleteid"];
$q = "delete from autoresponders where id=\"$deleteid\"";
$r = mysql_query($q);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">THE AUTORESPONDER MESSAGE WAS DELETED</div></td></tr>
<tr><td align="center"><br><a href="autorespondercontrol.php">BACK TO AUTORESPONDER MESSAGES ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "deleteautoresponder")
################################################################
if ($autoresponderformat == "html")
{
$content = htmlspecialchars($autorespondermessage);
}
if ($autoresponderformat != "html")
{
$content = $autorespondermessage;
}
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<script language="JavaScript" type="text/javascript">
var copytoclip=1
function HighlightAll(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()
if (document.all&&copytoclip==1){
therange=tempval.createTextRange()
therange.execCommand("Copy")
window.status="Contents highlighted and copied to clipboard!"
setTimeout("window.status=''",1800)
}
}
</script>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
//mode : "textareas",
mode : "specific_textareas",
editor_selector : "myEditor",
theme : "advanced",
extended_valid_elements : "a[href|target|name],font[face|size|color|style],span[class|align|style]"
});
</script>
<!-- /tinyMCE --> 
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">BASIC AUTORESPONDER SETTINGS</div></td></tr>

<form method="POST" action="autorespondercontrol.php">
<tr><td align="center" colspan="2"><br>MAIN WEBSITE DOMAIN (include http:// and NO trailing slash): &nbsp;<input type="text" name="newdomain" class="typein" maxlength="255" size="16" value="<?php echo $domain ?>"></td></tr>
<tr><td align="center" colspan="2">MAIN WEBSITE NAME: &nbsp;<input type="text" name="newtitle" class="typein" maxlength="255" size="16" value="<?php echo $title ?>"></td></tr>
<tr><td align="center" colspan="2">ADMIN LOGIN USERNAME: &nbsp;<input type="text" name="newadminuser" class="typein" maxlength="255" size="16" value="<?php echo $adminuser ?>"></td></tr>
<tr><td align="center" colspan="2">ADMIN LOGIN PASSWORD: &nbsp;<input type="text" name="newadminpass" class="typein" maxlength="255" size="16" value="<?php echo $adminpass ?>"></td></tr>
<tr><td align="center" colspan="2">ADMIN EMAIL FOR AUTORESPONDER SIGNUPS: &nbsp;<input type="text" name="newwebmasteremail" class="typein" maxlength="255" size="35" value="<?php echo $webmasteremail ?>"></td></tr>
<tr><td align="center" colspan="2">AUTO RESPONDER EMAIL ADDRESS: &nbsp;<input type="text" name="newautoresponderemail" class="typein" maxlength="255" size="35" value="<?php echo $autoresponderemail ?>"></td></tr>
<tr><td align="center" colspan="2">URL PEOPLE VISIT AFTER SUBMITTING THE FORM: &nbsp;<input type="text" name="newredirecturl" class="typein" maxlength="255" size="35" value="<?php echo $redirecturl ?>"></td></tr>
<tr><td align="center" colspan="2">DISCLAIMER FOR SIGNUPS (do NOT include a remove link because this is added automatically to the end of all the email):<br><br><textarea cols="95" rows="10" name="newdisclaimer" class="myEditor"><?php echo $disclaimer ?></textarea></td></tr>
<tr><td align="center" colspan="2">DISCLAIMER FOR IMPORTS (do NOT include a remove link because this is added automatically to the end of all the email):<br><br><textarea cols="95" rows="10" name="newdisclaimerimports" class="myEditor"><?php echo $disclaimerimports ?></textarea></td></tr>
<tr><td colspan="2" align="center"><br><input type="hidden" name="action" value="savesettings"><input type="submit" value="SAVE AUTORESPONDER SETTINGS" class="sendit"></form></td></tr>


<tr><td colspan="2"><br>&nbsp;<br>&nbsp;</td></tr>

<tr><td colspan="2" align="center"><br><div style="font-size: 18px; font-weight: bold;">CREATE NEW AUTORESPONDER EMAIL MESSAGE</div></td></tr>
<tr><td colspan="2" align="center"><br>Use ~FIRSTNAME~ or ~LASTNAME~ anywhere in the message subject or body to substitute for the prospect's name.</td></tr>
<form action="autorespondercontrol.php" method="post" name="addform">
<tr><td colspan="2" align="center" ><br>AutoResponder Campaign: </td></tr><tr><td colspan="2" align="center"><input type="text" name="newautorespondertitle" maxlength="255" size="95" class="typein"></td></tr>
<tr><td colspan="2" align="center" ><br>Type Your Name That Should Appear In The From Field: </td></tr><tr><td colspan="2" align="center"><input type="text" name="newautoresponderfromfield" maxlength="255" size="95" class="typein"></td></tr>
<tr><td colspan="2" align="center" ><br>Type In Your AutoResponder Subject:</td></tr><tr><td colspan="2" align="center"><input type="text" class="typein" name="newautorespondersubject" maxlength="255" size="95"></td></tr>
<tr><td colspan="2" align="center" ><br>Type In Your AutoResponder Message Body:</td></tr><tr><td colspan="2" align="center"><textarea name="newautorespondermessage" rows="15" cols="95" class="myEditor"></textarea></td></tr>
<tr><td colspan="2" align="center" ><br>Prospect Groups To Send To:</td></tr><tr><td colspan="2" align="center"><br>
<div style="width: 200px; text-align: left;">
<?php
$groupsq = "select * from prospectgroups order by prospectgroupname";
$groupsr = mysql_query($groupsq);
while ($groupsrowz = mysql_fetch_array($groupsr))
{
$pid = $groupsrowz["id"];
$prospectgroupname = $groupsrowz["prospectgroupname"];
?>
<input type="checkbox" name="newprospectgroups[]" value="<?php echo $prospectgroupname ?>">&nbsp;<?php echo $prospectgroupname ?><br>
<?php
}
?>
</div>
</td></tr>
<tr><td colspan="2" align="center" ><br>Send After How Many Days? (select 0 for immediately after signup):&nbsp;&nbsp;
<select name="newautoresponderdays" class="pickone">
<?php
for($i=0;$i<=100;$i++)
{
?>
<option value="<?php echo $i ?>"><?php echo $i ?></option>
<?php
}
?>
</select>
</td></tr>
<tr><td colspan="2" align="center"><br><input type="hidden" name="action" value="addautoresponder"><input type="submit" value="ADD" class="sendit"></form></td></tr>

<tr><td colspan="2"><br>&nbsp;<br>&nbsp;</td></tr>

<tr><td colspan="2" align="center"><br><div style="font-size: 18px; font-weight: bold;">EXISTING AUTORESPONDER CAMPAIGNS</div></td></tr>

<?php
$arq = "select * from autoresponders order by autorespondertitle";
$arr = mysql_query($arq);
$arrows = mysql_num_rows($arr);
if ($arrows < 1)
{
?>
<tr><td align="center" colspan="2"><br>You haven't created any AutoResponders yet. Please use the form above to make some.</td></tr>
<?php
}
if ($arrows > 0)
{
?>
<tr><td align="center" colspan="2"><br><table cellpadding="4" cellspacing="2" border="0" align="center" bgcolor="#999999">
<tr bgcolor="#d3d3d3">
<td align="center">Campaign Name</td>
<td align="center">From Field</td>
<td align="center">Subject</td>
<td align="center">Message</td>
<td align="center">Sent How Many Days After Subscribing?</td>
<td align="center">Prospect&nbsp;Groups&nbsp;Who&nbsp;Receive</td>
<td align="center">Total Mailed</td>
<td align="center">Save</td>
<td align="center">Delete</td>
<td align="center">Copy HTML Code for Pages/Emails</td>
</tr>
<?php
	while ($arrowz = mysql_fetch_array($arr))
	{
	$id = $arrowz["id"];
	$autorespondertitle = $arrowz["autorespondertitle"];
	$autorespondermessage = $arrowz["autorespondermessage"];
	$autorespondermessage = stripslashes($autorespondermessage);
	$autorespondermessage = str_replace('\\', '', $autorespondermessage);
	$autorespondersubject = $arrowz["autorespondersubject"];
	$autorespondersubject = stripslashes($autorespondersubject);
	$autorespondersubject = str_replace('\\', '', $autorespondersubject);
	$autoresponderfromfield = $arrowz["autoresponderfromfield"];
	$autoresponderdays = $arrowz["autoresponderdays"];
	$sendtoprospectgroups = $arrowz["sendtoprospectgroups"];
	$totalmailed = $arrowz["totalmailed"];
?>
<form action="autorespondercontrol.php" method="post">
<tr bgcolor="#eeeeee">
<td align="center"><input type="text" name="saveautorespondertitle" class="typein" size="25" maxlength="255" value="<?php echo $autorespondertitle ?>"></td>
<td align="center"><input type="text" name="saveautoresponderfromfield" class="typein" size="25" maxlength="255" value="<?php echo $autoresponderfromfield ?>"></td>
<td align="center"><input type="text" name="saveautorespondersubject" class="typein" size="25" maxlength="255" value="<?php echo $autorespondersubject ?>"></td>
<td align="center"><textarea name="saveautorespondermessage" rows="20" cols="50" class="myEditor"><?php echo $autorespondermessage ?></textarea></td>
<td align="center"><select name="saveautoresponderdays" class="pickone">
<?php
for ($i=0;$i<=100;$i++)
{
?>
<option value="<?php echo $i ?>" <?php if ($i == $autoresponderdays) { echo "selected"; } ?>><?php echo $i ?></option>
<?php
}
?>
</select></td>
<td>
<?php
$pq = "select * from prospectgroups order by prospectgroupname";
$pr = mysql_query($pq);
$prows = mysql_num_rows($pr);
if ($prows > 0)
{
$sendtoprospectgroups_array = explode("~",$sendtoprospectgroups);
while ($prowz = mysql_fetch_array($pr))
	{
	$prospectgroupname = $prowz["prospectgroupname"];
	if (in_array($prospectgroupname, $sendtoprospectgroups_array))
		{
		?>
		<input type="checkbox" name="saveprospectgroups[]" value="<?php echo $prospectgroupname ?>" checked> <?php echo $prospectgroupname ?><br>
		<?php
		}
	else
		{
		?>
		<input type="checkbox" name="saveprospectgroups[]" value="<?php echo $prospectgroupname ?>"> <?php echo $prospectgroupname ?><br>
		<?php
		}
	} # while ($prowz = mysql_fetch_array($pr))
}
?>
</td>
<td align="center"><?php echo $totalmailed ?></td>
<td align="center">
<input type="hidden" name="action" value="saveautoresponder">
<input type="hidden" name="saveid" value="<?php echo $id ?>">
<input type="submit" value="SAVE">
</form>
</td>
<form method="POST" action="autorespondercontrol.php">
<td align="center">
<input type="hidden" name="action" value="deleteautoresponder">
<input type="hidden" name="deleteid" value="<?php echo $id ?>">
<input type="submit" value="DELETE">
</form>
</td>

<form name="theform<?php echo $id ?>">
<td align="center">
<div align="left">
If you want to use the autoresponder on any webpage or in HTML email, copy and paste the form code below from the box into your HTML.<br>
<b>IMPORTANT:</b> REPLACE the word "YOUR_MAILING_LIST_GROUP" in the code below (near the bottom) with the name of the Mailing List Group you want the signups to be assigned to.<br>
If left as is or blank, it will default to the "MAIN" mailing list group.
</div>
<textarea rows="10" cols="50" name="formcode" type=submit value=Submit name=B1>
<form action="<?php echo $domain ?>/submit.php" method="post">
<P align=center><FONT face=Verdana size=2>Your 
First Name:</FONT>&nbsp;<input type="text" name="firstname"></P>
<P align=center><FONT face=Verdana size=2>Your 
Last Name:</FONT>&nbsp;<input type="text" name="lastname"></P>
<P align=center><FONT face=Verdana size=2>Your 
Email Address:</FONT>&nbsp;<input type="text" name="email"></P>
<P align=center><FONT face=Verdana size=2>Please 
tell us how you found us?</FONT></P>
<P align=center><select size="1" name="howfound">
<option>Email Ad</option>
<option>Website Ad or Banner</option>
<option>Postal Letter</option>
<option>Magazine Ad</option>
<option>Newspaper Ad</option>
<option>Search Engine</option>
<option>Traffic Swarm</option> 
<option>Ebay</option>
<option>Other</option>
</SELECT></P>
<p align=center>
<input type="hidden" name="prospectgroup" value="YOUR_MAILING_LIST_GROUP">
<input type="submit" value="Subscribe" class="sendit"></p></form>
</textarea>
<center><a href="javascript: HighlightAll('theform<?php echo $id ?>.formcode')">copy all form code</a></center>
</form>
</td>

</tr>

<tr bgcolor="#d3d3d3"><td colspan="10"></td></tr>
<?php
	} # while ($arrowz = mysql_fetch_array($arr))
?>
</table></td></tr>
<?php
} # if ($arrows > 0)
?>

<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table><br><br>&nbsp;
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
?>