<?php
$DBhost = "localhost";
$DBuser = "phpsites_demoara";
$DBpass = "6;&^e0A;%I4a";
$DBName = "phpsites_demoautoresponderma";
$connection = mysql_connect($DBhost, $DBuser, $DBpass) or die ("Unable to connect to server");
@mysql_select_db("$DBName") or die ("Sorry, Database extremely busy. Please try again shortly.");
$sqlquery = "select * from admin";
$sqlresult = mysql_query($sqlquery);
$sqlrows = mysql_num_rows($sqlresult);
if ($sqlrows > 0)
{
$adminuser = mysql_result($sqlresult,0,"username");
$adminpass = mysql_result($sqlresult,0,"password");
$domain = mysql_result($sqlresult,0,"domain");
$title = mysql_result($sqlresult,0,"title");
$webmasteremail = mysql_result($sqlresult,0,"webmasteremail");
$autoresponderemail = mysql_result($sqlresult,0,"autoresponderemail");
$redirecturl = mysql_result($sqlresult,0,"redirecturl");
$disclaimer = mysql_result($sqlresult,0,"disclaimer");
$disclaimerimports = mysql_result($sqlresult,0,"disclaimerimports");
$editpageshtmleditor = mysql_result($sqlresult,0,"editpageshtmleditor");
}
if ($sqlrows < 1)
{
echo 'Database error. Please contact <a href="mailto:sabrina@phpsitescripts.com">sabrina@phpsitescripts.com</a> to report this problem and the name/URL of the website you were trying to access.';
exit;
}
extract($_REQUEST);
?>