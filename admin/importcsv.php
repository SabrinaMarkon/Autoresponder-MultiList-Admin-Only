<?php
include "admincontrol.php";
$action = $_POST["action"];
if ($action == "importcsv")
{
$theuploadedcsvfile = $_POST["theuploadedcsvfile"];
$theuploadedcsvfile_name = $_FILES["theuploadedcsvfile"]["name"];
$theuploadedcsvfile_type = $_FILES["theuploadedcsvfile"]["type"];
$prospectgroupname = $_POST["prospectgroupname"];

$dir = "../csv";
$temp = $dir . "/" . $theuploadedcsvfile_name;
$type = $theuploadedcsvfile_type;

# blank filename
if ($theuploadedcsvfile_name == "")
{
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
<tr><td colspan="2" align="center"><br>You did not select a file to upload. Please browse for the .csv file on your computer and try again.
</td></tr>
<tr><td align="center" colspan="2"><br>
<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
</td></tr>
<tr><td align="center"><br><a href="importcsv.php">BACK TO CSV IMPORT ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
}

# wrong type of file
$theuploadedcsvfilename_array = explode(".", $theuploadedcsvfile_name);
$extension = $theuploadedcsvfilename_array[1];
if ($extension != "csv")
{
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
<tr><td colspan="2" align="center"><br>The filename you selected to upload was not a .csv file. Please check the filename and try again.
</td></tr>
<tr><td align="center" colspan="2"><br>
<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
</td></tr>
<tr><td align="center"><br><a href="importcsv.php">BACK TO CSV IMPORT ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
}

# filename already exists on the server
if (@file_exists($temp))
{
@chmod($temp,0777);
@unlink($temp);
} # if (file_exists($temp))

# copy file
if(move_uploaded_file($_FILES['theuploadedcsvfile']['tmp_name'], $temp)) 
{
@chmod($temp,0777);
$opencsvfile = file($temp);
$csvcounter = count($opencsvfile);
$csvfilearray = file($temp);
$seperator = ",";
$csvfieldcount = 4;
# check if file is 0 bytes (no records!)
$isfileempty = filesize($temp);
if ($isfileempty == 0)
	{
@unlink($temp);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
<tr><td colspan="2" align="center"><br>The file you selected to upload is empty.
</td></tr>
<tr><td align="center" colspan="2"><br>
<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
</td></tr>
<tr><td align="center"><br><a href="importcsv.php">BACK TO CSV IMPORT ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
	}
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><div style="font-size: 18px; font-weight: bold;">IMPORTING YOUR CONTACTS PLEASE WAIT...</div></td></tr>
<tr><td align="center">
<?php
# check for wrong number of fields
	for($i=0; $i<$csvcounter; $i++)
	{
?>
<br>
<?php
$csvitem = explode("$seperator", $csvfilearray[$i]);
$fieldsinthisrow = count($csvitem);
	if ($fieldsinthisrow > 3)
		{
# correct number of fields
$csvquery = "insert into prospects (firstname, lastname, email, howfound, referringpage, prospectgroup) values (\"$csvitem[0]\", \"$csvitem[1]\", \"$csvitem[2]\", \"$csvitem[3]\", \"ADMIN IMPORT\", \"$prospectgroupname\")";
$csvresult = mysql_query($csvquery);
if ($csvresult)	
{
$show = "<font color=blue>$csvitem[0] $csvitem[1]</font> with email <font color=blue>$csvitem[2]</font>";

$arq = "select * from autoresponders where sendtoprospectgroups like \"%$prospectgroupname%\" and autoresponderdays=\"0\" order by id";
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
$removelink = "<br><br>" . $disclaimerimports . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $csvitem[2] . ">" . $domain . "/remove.php?r=" . $csvitem[2] . "</a><br>";

$to2 = $csvitem[2];
$subject2 = $autorespondersubject;

$subject2 = ereg_replace ("~FIRSTNAME~", $csvitem[0], $autorespondersubject);
$subject2 = ereg_replace ("~LASTNAME~", $csvitem[1], $subject2);
#$subject2 = stripslashes($subject2);
$autorespondermessage = ereg_replace ("~FIRSTNAME~", $csvitem[0], $autorespondermessage);
$autorespondermessage = ereg_replace ("~LASTNAME~", $csvitem[1], $autorespondermessage);
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

echo "<font size=2>" . $show . " was <font color=blue>ADDED SUCCESSFULLY!</font></font><br>";

}
else
{
$show = "<font color=red>$csvitem[0] $csvitem[1]</font> with email <font color=red>$csvitem[2]</font>";
echo "<font size=2>" . $show . " was <font color=red>NOT ADDED</font></font><br>";
}
		}
	if ($fieldsinthisrow < 4)
		{
# wrong number of fields
$show = "Record with first field <font color=red>$csvitem[0] $csvitem[1]</font>";
echo "<font size=2>" . $show . " was <font color=red>NOT ADDED - LOOKS LIKE THIS RECORD MAY HAVE THE WRONG NUMBER OF FIELDS</font></font><br>";
		}
	} # for($i=0; $i<$csvcounter; $i++)
?>
</td></tr>
<tr><td align="center"><br><a href="importcsv.php">BACK TO CSV IMPORT ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if(@move_uploaded_file($_FILES['theuploadedcsvfile']['tmp_name'], $dir)) 

# some problem - probably permissions
else 
{
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
<tr><td colspan="2" align="center"><br>There was a problem with uploading your file due to incorrect permissions on your server not allowing the upload.
</td></tr>
<tr><td align="center" colspan="2"><br>
<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
</td></tr>
<tr><td align="center"><br><a href="importcsv.php">BACK TO CSV IMPORT ADMIN</a></td></tr>
<tr><td align="center"><a href="controlpanel.php">BACK TO MAIN ADMIN CONTROL PANEL</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # else 

} # if ($action == "importcsv")

include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">IMPORT CSV FILE OF PROSPECTS</div></td></tr>
<tr><td colspan="2"><br>
Please browse to find your csv file on your computer and upload it with the below form. For this function to work well, the file MUST meet the below requirements!<br><br>
<ol>
<li>The file needs to have FOUR fields in it, the prospect's First Name, Last Name, Email, and Where-They-Signed-Up-From <u>IN THAT ORDER</u> (like the form on the main page people fill out), to be sure that the records are correctly entered into your database.<br>&nbsp;</li>
<li>The fields in the CSV file <u>must be each separated with a comma</u>, and each record by a line return (this is typical of csv files).<br>&nbsp;</li>
<li>The filename <u>must end with extension .csv</u> like filename.csv for instance.<br>&nbsp;</li>
<li>Field values <u>should not</u> have commas in them (which may cause unpredictable results because the .csv separator value is a comma)</li>
</ol>
<br><br>If you need to be able to import files in any format other than this, I can make that for you if you let me know what you need :)
</td></tr>
<form enctype="multipart/form-data" action="importcsv.php" method="post" name="theform">
<tr><td colspan="2"><br>UPLOAD YOUR .CSV FILE: &nbsp;<input type="file" class="typein" name="theuploadedcsvfile"><input type="hidden" name="action" value="importcsv">&nbsp;&nbsp;
Import Into Mailing List Group:&nbsp;<select name="prospectgroupname">
<?php
$groupq = "select * from prospectgroups order by prospectgroupname";
$groupr = mysql_query($groupq);
while ($grouprowz = mysql_fetch_array($groupr))
{
$prospectgroupname = $grouprowz["prospectgroupname"];
?>
<option value="<?php echo $prospectgroupname ?>"><?php echo $prospectgroupname ?></option>
<?php
}
?>
</select>
&nbsp;&nbsp;<input type="submit" value="IMPORT" class="sendit"></td></tr>
</form>
<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
?>