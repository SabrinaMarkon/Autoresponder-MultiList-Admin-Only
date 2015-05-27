<?php
include "../incs/db.php";

$adddayq = "update prospects set day=day+1";
$adddayr = mysql_query($adddayq);

$arq = "select * from autoresponders where autoresponderdays>0 order by autoresponderdays";
$arr = mysql_query($arq);
$arrows = mysql_num_rows($arr);
if ($arrows > 0)
{
	while ($arrowz = mysql_fetch_array($arr))
	{
 	$id = $arrowz["id"];
	$autorespondertitle = $arrowz["autorespondertitle"];
	$autorespondermessage = $arrowz["autorespondermessage"];
	$autorespondersubject  = $arrowz["autorespondersubject"];
	$autoresponderfromfield = $arrowz["autoresponderfromfield"];
	$autoresponderdays = $arrowz["autoresponderdays"];
	$sendtoprospectgroups = $arrowz["sendtoprospectgroups"];
	$sendtoprospectgroups_array = explode("~",$sendtoprospectgroups);
	$buildquery = "";
	foreach ($sendtoprospectgroups_array as $group)
		{
		if ($group != "")
			{
			$buildquery .= "prospectgroup=\"$group\" or ";
			}
		}
	$buildquery = substr($buildquery, 0, -4); 
	$pq = "select * from prospects where day=\"$autoresponderdays\" and (".$buildquery.")";
	$pr = mysql_query($pq);
	$prows = mysql_num_rows($pr);
	if ($prows > 0)
		{
		while ($prowz = mysql_fetch_array($pr))
			{

			$firstname = $prowz["firstname"];
			$lastname = $prowz["lastname"];
			$email = $prowz["email"];

			$countq = "update autoresponders set totalmailed=totalmailed+1 where id=\"$id\"";
			$countr = mysql_query($countq);

			$removelink = "<br><br>" . $disclaimer . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $email . ">" . $domain . "/remove.php?r=" . $email . "</a><br>";

			$to = $email;
			$subject = $autorespondersubject;
			$subject = ereg_replace ("~FIRSTNAME~", $firstname, $autorespondersubject);
			$subject = ereg_replace ("~LASTNAME~", $lastname, $subject);
			#$subject = stripslashes($subject);
			$autorespondermessage = ereg_replace ("~FIRSTNAME~", $firstname, $autorespondermessage);
			$autorespondermessage = ereg_replace ("~LASTNAME~", $lastname, $autorespondermessage);
			#$autorespondermessage = stripslashes($autorespondermessage);
			$message = $autorespondermessage . $removelink;

			$headers = "From: $autoresponderfromfield <$autoresponderemail>\n" .
					   "MIME-Version: 1.0\n" .
					   "Content-Type: text/html; charset=windows-1252\n" .
					   "X-Mailer: PHP - $title Auto Response\n" .
						"Return-Path: $autoresponderemail\n";

			@mail ($to, $subject, $message, $headers, "-f" . $autoresponderemail);

			} # while ($prowz = mysql_fetch_array($pr))
		} # if ($prows > 0)
	} # while ($arrowz = mysql_fetch_array($arr))
} # if ($arrows > 0)

exit;
?>