<?php
include "./incs/db.php";
$firstname = $_REQUEST["firstname"];
$lastname = $_REQUEST["lastname"];
$email = $_REQUEST["email"];
$phone = $_REQUEST["phone"];
$howfound = $_REQUEST["howfound"];
$referringpage = $_SERVER["HTTP_REFERER"];
$prospectgroup = $_REQUEST["prospectgroup"];
if(!$firstname)
{
$error .= "<li>Please return and enter your first name.</li>";
}
if(!$lastname)
{
$error .= "<li>Please return and enter your last name.</li>";
}
if(!$email)
{
$error .= "<li>Please return and enter your email address.</li>";
}
if(!$error == "")
{
include "header.php";
?>
<!-- CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #FF0000; font-family: Verdana;">ERROR</div></td></tr>
<tr><td colspan="2"><P align=justify><FONT face=Verdana 
color=#005353 size=2><br>Please return to the form and correct the following problems:<br>
<ul><?php echo $error ?></ul></p>
</td></tr>
<tr><td align="center" colspan="2">
<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
</td></tr>
</table>
<!-- END CONTENT //-->
<?php
include "footer.php";
exit;
}

$checkgroupq = "select * from prospectgroups where prospectgroupname=\"$prospectgroup\"";
$checkgroupr = mysql_query($checkgroupq);
$checkgrouprows = mysql_num_rows($checkgroupr);
if ($checkgrouprows > 0)
{
$showprospectgroup = $prospectgroup;
}
if ($checkgrouprows < 1)
{
$showprospectgroup = "MAIN";
}

$q = "insert into prospects (firstname,lastname,email,phone,howfound,referringpage,day,prospectgroup) values (\"$firstname\",\"$lastname\",\"$email\",\"$phone\",\"$howfound\",\"$referringpage\",\"0\",\"$showprospectgroup\")";
$r = mysql_query($q);

## email the admin
$to1 = $webmasteremail;
$headers1 = "From: $title <$autoresponderemail>";
$subject1 = "A new prospect has requested an autoresponder message!";
$message1 = "Here is the information they submitted:
First Name: $firstname
Last Name: $lastname
Email: $email
Phone: $phone
Referring Page: $referringpage
How They Found Your Site: $howfound
Prospect Group: $showprospectgroup

This information has also been saved into your admin area at
$domain/admin
You can login there at any time to view your prospects or to
change your autoresponder messages.

";
@mail ($to1, $subject1, $message1, $headers1, "-f" . $autoresponderemail);

$arq = "select * from autoresponders where sendtoprospectgroups like \"%$showprospectgroup%\" and autoresponderdays=\"0\" order by id";
$arr = mysql_query($arq);
$arrows = mysql_num_rows($arr);
if ($arrows > 0)
{
	while ($arrowz = mysql_fetch_array($arr))
	{
	$autoresponderid = $arrowz["id"];
	$autorespondertitle = $arrowz["autorespondertitle"];
	$autorespondermessage = $arrowz["autorespondermessage"];
	$autorespondersubject = $arrowz["autorespondersubject"];
	$autoresponderformat = $arrowz["autoresponderformat"];
	$autoresponderfromfield = $arrowz["autoresponderfromfield"];

$countq = "update autoresponders set totalmailed=totalmailed+1 where id=\"$autoresponderid\"";
$countr = mysql_query($countq);

## send the autoresponder to the prospect
$removelink = "<br><br>" . $disclaimer . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $email . ">" . $domain . "/remove.php?r=" . $email . "</a><br>";

$to2 = $email;
$subject2 = $autorespondersubject;

$subject2 = ereg_replace ("~FIRSTNAME~", $firstname, $autorespondersubject);
$subject2 = ereg_replace ("~LASTNAME~", $lastname, $subject2);
#$subject2 = stripslashes($subject2);
$autorespondermessage = ereg_replace ("~FIRSTNAME~", $firstname, $autorespondermessage);
$autorespondermessage = ereg_replace ("~LASTNAME~", $lastname, $autorespondermessage);
#$autorespondermessage = stripslashes($autorespondermessage);

$message2 = $autorespondermessage . $removelink;

$headers2 = "From: $autoresponderfromfield <$autoresponderemail>\n" .
           "MIME-Version: 1.0\n" .
           "Content-Type: text/html; charset=windows-1252\n" .
           "X-Mailer: PHP - $title Auto Response\n" .
            "Return-Path: $autoresponderemail\n";

@mail ($to2, $subject2, $message2, $headers2, "-f" . $autoresponderemail);

	} # while ($arrowz = mysql_fetch_array($arr))
} # if ($arrows > 0)
include "header.php";
?>
<!-- CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #FF0000; font-family: Verdana;">Thank You for Registering!</div></td></tr>
<tr><td colspan="2"><P align=justify><FONT face=Verdana 
color=#005353 size=2><br>we will keep you informed of any new opportunities we come across that REALLY work!</p>
</td></tr>
<?php
if ($redirecturl != "")
{
?>
<tr><td align="center" colspan="2">
<a href="<?php echo $redirecturl ?>">Please click here to continue</a>
</td></tr>
<?php
}
?>
</table>
<!-- END CONTENT //-->
<?php
include "footer.php";
exit;
?>