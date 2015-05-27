<?php
include "admincontrol.php";
$action = $_POST["action"];
if ($action == "remove")
{
$deleteid = $_POST["deleteid"];
$q = "delete from prospects where id=\"$deleteid\"";
$r = mysql_query($q);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">Prospect ID <?php echo $deleteid ?> with Email <?php echo $deleteemail ?> Was Deleted from your Database</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="prospectlist.php">Return To Prospect List</a><br><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "remove")
####################################################################
if ($action == "save")
{
$saveid = $_POST["saveid"];
$saveprospectgroup = $_POST["saveprospectgroup"];
$saveemail = $_POST["saveemail"];
$savefirstname = $_POST["savefirstname"];
$savelastname = $_POST["savelastname"];
$savephone = $_POST["savephone"];
$savehowfound = $_POST["savehowfound"];
$savereferringpage = $_POST["savereferringpage"];
$saveday = $_POST["saveday"];
if(!$saveemail)
{
$error .= "<li>Please return and enter the email address of the prospect.</li>";
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
$q = "update prospects set firstname=\"$savefirstname\",lastname=\"$savelastname\",email=\"$saveemail\",phone=\"$savephone\",howfound=\"$savehowfound\",referringpage=\"$savereferringpage\",day=\"$saveday\",prospectgroup=\"$saveprospectgroup\" where id=\"$saveid\"";
$r = mysql_query($q);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">Prospect ID <?php echo $saveid ?> With Email <?php echo $saveemail ?> Was Saved</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="prospectlist.php">Return To Prospect List</a><br><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "save")
####################################################################
if ($action == "addprospectgroup")
{
$newprospectgroupname = $_POST["newprospectgroupname"];
if(!$newprospectgroupname)
{
$error .= "<li>Please return and enter a name for the mailing list.</li>";
}
$dupq = "select * from prospectgroups where prospectgroupname=\"$newprospectgroupname\"";
$dupr = mysql_query($dupq);
$duprows = mysql_num_rows($dupr);
if ($duprows > 0)
	{
	$error .= "<li>The name " . $newprospectgroupname . " is already in use for a mailing list name.</li>";
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
$q = "insert into prospectgroups (prospectgroupname) values (\"$newprospectgroupname\")";
$r = mysql_query($q);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">New Mailing List Group <?php echo $newprospectgroupname ?> Created!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="prospectlist.php">Return To Prospect List</a><br><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "addprospectgroup")
####################################################################
if ($action == "deleteprospectgroup")
{
$deleteprospectgroupname = $_POST["deleteprospectgroupname"];
$changetoprospectgroupname = $_POST["changetoprospectgroupname"];
$q1 = "update prospects set prospectgroup=\"$changetoprospectgroupname\" where prospectgroup=\"$deleteprospectgroupname\"";
$r1 = mysql_query($q1);
$q2 = "delete from prospectgroups where prospectgroupname=\"$deleteprospectgroupname\"";
$r2 = mysql_query($q2);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">Mailing List Group <?php echo $deleteprospectgroupname ?> Was Deleted!</div></td></tr>
<tr><td align="center" colspan="2"><br>All prospects that were in that mailing list group were reassigned to the <?php echo $changetoprospectgroupname ?> group instead.</td></tr>
<tr><td align="center" colspan="2"><br><a href="prospectlist.php">Return To Prospect List</a><br><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "deleteprospectgroup")
####################################################################
if ($action == "saveprospectgroup")
{
$oldprospectgroupname = $_POST["oldprospectgroupname"];
$saveprospectgroupname = $_POST["saveprospectgroupname"];
if(!$saveprospectgroupname)
{
$error .= "<li>Please return and enter a name for the mailing list.</li>";
}
$dupq = "select * from prospectgroups where prospectgroupname=\"$saveprospectgroupname\"";
$dupr = mysql_query($dupq);
$duprows = mysql_num_rows($dupr);
if ($duprows > 0)
	{
	$error .= "<li>The name " . $saveprospectgroupname . " is already in use for a mailing list name.</li>";
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
$q1 = "update prospects set prospectgroup=\"$saveprospectgroupname\" where prospectgroup=\"$oldprospectgroupname\"";
$r1 = mysql_query($q1);
$q2 = "update prospectgroups set prospectgroupname=\"$saveprospectgroupname\" where prospectgroupname=\"$oldprospectgroupname\"";
$r2 = mysql_query($q2);
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">Mailing List Group <?php echo $oldprospectgroupname ?> Was Renamed To <?php echo $saveprospectgroupname ?>!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="prospectlist.php">Return To Prospect List</a><br><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "saveprospectgroup")
####################################################################
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">CREATE NEW PROSPECT MAILING LIST GROUP</div></td></tr>
<tr><td align="center" colspan="2"><br>
<table cellpadding="2" cellspacing="2" border="0" align="center" bgcolor="#999999">
<form action="prospectlist.php" method="post">
<tr bgcolor="#eeeeee"><td>Mailing List (Group) Name:</td><td><input type="text" name="newprospectgroupname" maxlength="255" size="15"></td></tr>
<tr bgcolor="#d3d3d3"><td align="center" colspan="2"><input type="hidden" name="action" value="addprospectgroup"><input type="submit" value="ADD"></form></td></tr>
</table>
</td></tr>


<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>


<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">EXISTING PROSPECT MAILING LIST GROUPS</div></td></tr>
<tr><td align="center" colspan="2"><br>
<table cellpadding="2" cellspacing="2" border="0" align="center" bgcolor="#999999">
<tr bgcolor="#d3d3d3"><td align="center"><b>Group Name</b></td><td align="center"><b>Save</b></td><td align="center"><b>Delete</b></td></tr>
<?php
$groupq = "select * from prospectgroups order by prospectgroupname";
$groupr = mysql_query($groupq);
while ($grouprowz = mysql_fetch_array($groupr))
{
$prospectgroupname = $grouprowz["prospectgroupname"];
?>
<tr bgcolor="#eeeeee">
<?php
if ($prospectgroupname == "MAIN")
	{
	?>
	<td align="center"><?php echo $prospectgroupname ?></td>
	<td align="center">N/A</td>
	<?php
	}
if ($prospectgroupname != "MAIN")
	{
?>
<form action="prospectlist.php" method="post">
<td align="center"><input type="text" name="saveprospectgroupname" value="<?php echo $prospectgroupname ?>" size="15" maxlength="255"></td>
<td align="center"><input type="hidden" name="oldprospectgroupname" value="<?php echo $prospectgroupname ?>"><input type="hidden" name="action" value="saveprospectgroup"><input type="submit" value="SAVE"></form></td>
<?php
	}
if ($prospectgroupname == "MAIN")
	{
	?>
	<td align="center">N/A</td>
	<?php
	}
if ($prospectgroupname != "MAIN")
	{
	?>
	<form action="prospectlist.php" method="post">
	<td align="center">
	Change Group For Existing Members When Deleted To:&nbsp;
	<select name="changetoprospectgroupname">
	<?php
	$changeq = "select * from prospectgroups where prospectgroupname!=\"$prospectgroupname\" order by prospectgroupname";
	$changer = mysql_query($changeq);
	while ($changerowz = mysql_fetch_array($changer))
		{
		$changetoname = $changerowz["prospectgroupname"];
		?>
		<option value="<?php echo $changetoname ?>"><?php echo $changetoname ?></option>
		<?php
		} # while ($changerowz = mysql_fetch_array($changer))
	?>
	</select>&nbsp;
	<input type="hidden" name="deleteprospectgroupname" value="<?php echo $prospectgroupname ?>"><input type="hidden" name="action" value="deleteprospectgroup"><input type="submit" value="DELETE"></form></td>
	<?php
	} # if ($prospectgroupname != "MAIN")
?>
</tr>
<?php
} # while ($grouprowz = mysql_fetch_array($groupr))
?>
</table>
</td></tr>


<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">PEOPLE WHO HAVE SUBSCRIBED TO YOUR AUTORESPONDERS</div></td></tr>
<tr><td align="center" colspan="2"><br>
<style type="text/css">
<!--
div.pagination {
	padding: 3px;
	margin: 3px;
}
div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #eeeeee;
	text-decoration: none;
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #808080;
	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #808080;	
	font-weight: bold;
	background-color: #808080;
	color: #FFF;
	}
div.pagination span.disabled {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #EEE;
	color: #DDD;
	}
-->
</style>
<?php
$searchfor = $_REQUEST["searchfor"];
$searchby = $_REQUEST["searchby"];
if ($searchfor != "")
{
$q = "select * from prospects where $searchby like \"%$searchfor%\" order by prospectgroup,email";
}
if ($searchfor == "")
{
$q = "select * from prospects order by prospectgroup,email";
}

$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
	if ($searchfor == "")
	{
	echo "Sorry, no one has submitted the form and requested your autoresponder message yet.";
	}
	if ($searchfor != "")
	{
	echo "No search results found.<br><br><a href=\"prospectlist.php\">Return to Main Prospect List</a><br><br>";
	}
}
if ($rows > 0)
{
################################################################
$pagesize = 200;

	$page = (empty($_GET['p']) || !isset($_GET['p']) || !is_numeric($_GET['p'])) ? 1 : $_GET['p'];
	$s = ($page-1) * $pagesize;
	$queryexclude1 = $q ." LIMIT $s, $pagesize";
	$resultexclude=mysql_query($queryexclude1);
	$numrows = @mysql_num_rows($resultexclude);
	if($numrows == 0){
		$queryexclude1 = $q ." LIMIT $pagesize";
		$resultexclude=mysql_query($queryexclude1);
	}
	$count = 0;
	$pagetext = "<center><br>Total Prospects: " . $rows . "<br>";

	if($rows > $pagesize){ // show the page bar
		$pagecount = ceil($rows/$pagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			if ($searchfor == "")
			{
			$pagetext .= "<a href='?p=".($page-1)."' title='previous page'>previous</a>";
			}
			if ($searchfor != "")
			{
			$pagetext .= "<a href='?p=".($page-1)."&searchfor=$searchfor&searchby=$searchby' title='previous page'>previous</a>";
			}
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				if ($searchfor == "")
				{
				$pagetext .= "<a href='?p=".$i."'>".$i."</a>";
				}
				if ($searchfor != "")
				{
				$pagetext .= "<a href='?p=".$i."&searchfor=$searchfor&searchby=$searchby'>".$i."</a>";
				}
			}
		}
		if($page<$pagecount){ //show previoust link
			if ($searchfor == "")
			{
			$pagetext .= "<a href='?p=".($page+1)."' title='next page'>next</a>";
			}
			if ($searchfor != "")
			{
			$pagetext .= "<a href='?p=".($page+1)."&searchfor=$searchfor&searchby=$searchby' title='next page'>next</a>";
			}
		}			
		$pagetext .= " </div><br>";
	}
################################################################
?>
<table cellpadding="2" cellspacing="2" border="0" align="center" bgcolor="#999999">

<form action="prospectlist.php" method="post">
<tr bgcolor="#d3d3d3"><td align="center" colspan="9">Search For:&nbsp;<input type="text" name="searchfor" size="15" maxlength="255">&nbsp;&nbsp;In:&nbsp;
<select name="searchby">
<option value="email">Email</option>
<option value="firstname">First Name</option>
<option value="lastname">Last Name</option>
<option value="prospectgroup">Prospect Group</option>
<!--<option value="phone">Phone</option>-->
<option value="howfound">How Found</option>
<option value="referringpage">Referring Webpage</option>
<option value="day">Days Since Subscribed</option>
</select>
&nbsp;&nbsp;
<input type="submit" value="SEARCH"></form></td></tr>

<tr bgcolor="#eeeeee"><td colspan="9" align="center"><div style="width:800px;overflow:auto;" align="center"><?php echo $pagetext ?></div></td></tr>
<tr bgcolor="#d3d3d3"><td align="center"><b>Prospect Group</b></td><td align="center"><b>Email</b></td><td align="center"><b>First Name</b></td><td align="center"><b>Last Name</b></td><!--<td align="center"><b>Phone</b></td>--><td align="center"><b>How They Found Your Site</b></td><td align="center"><b>Referring Webpage</b></td><td align="center"><b>Days Since Subscribed</b></td><td align="center"><b>Save</b></td><td align="center"><b>Remove</b></td></tr>
<?php
while ($rowz = mysql_fetch_array($resultexclude))
	{
$id = $rowz["id"];
$firstname = $rowz["firstname"];
$lastname = $rowz["lastname"];
$phone = $rowz["phone"];
$email = $rowz["email"];
$howfound = $rowz["howfound"];
$referringpage = $rowz["referringpage"];
$prospectgroup = $rowz["prospectgroup"];
$day = $rowz["day"];
?>
<tr bgcolor="#eeeeee">
<form action="prospectlist.php" method="post">
<td align="center"><select name="saveprospectgroup" class="pickone">
<?php
$pq = "select * from prospectgroups order by prospectgroupname";
$pr = mysql_query($pq);
$prows = mysql_num_rows($pr);
if ($prows > 0)
{
while ($prowz = mysql_fetch_array($pr))
	{
	$prospectgroupname = $prowz["prospectgroupname"];
?>
<option value="<?php echo $prospectgroupname ?>" <?php if ($prospectgroupname == $prospectgroup) { echo "selected"; } ?>><?php echo $prospectgroupname ?></option>
<?php
	}
}
?>
</select></td>
<td align="center"><input type="text" name="saveemail" class="typein" size="15" maxlength="255" value="<?php echo $email ?>"></td>
<td align="center"><input type="text" name="savefirstname" class="typein" size="15" maxlength="255" value="<?php echo $firstname ?>"></td>
<td align="center"><input type="text" name="savelastname" class="typein" size="15" maxlength="255" value="<?php echo $lastname ?>"></td>
<!--<td align="center"><input type="text" name="savephone" class="typein" size="15" maxlength="255" value="<?php echo $phone ?>"></td>-->
<td align="center"><input type="text" name="savehowfound" class="typein" size="15" maxlength="255" value="<?php echo $howfound ?>"></td>
<td align="center"><input type="text" name="savereferringpage" class="typein" size="15" maxlength="255" value="<?php echo $referringpage ?>"></td>
<td align="center">
<select name="saveday" class="pickone">
<?php
for($i=0;$i<=100;$i++)
{
?>
<option value="<?php echo $i ?>" <?php if ($i == $day) { echo "selected"; } ?>><?php echo $i ?></option>
<?php
}
?>
</select>
</td>
<td align="center">
<input type="hidden" name="action" value="save">
<input type="hidden" name="saveid" value="<?php echo $id ?>">
<input type="submit" value="SAVE">
</form>
</td>
<form action="prospectlist.php" method="post">
<td align="center"><input type="hidden" name="action" value="remove">
<input type="hidden" name="deleteid" value="<?php echo $id ?>">
<input type="hidden" name="deleteemail" value="<?php echo $email ?>">
<input type="submit" value="REMOVE">
</td></form>
</tr>
<tr bgcolor="#d3d3d3"><td colspan="9"></td></tr>
<?php
	}
?>
</table>
<?php
}
?>
</td></tr>
<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<br><br>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
?>