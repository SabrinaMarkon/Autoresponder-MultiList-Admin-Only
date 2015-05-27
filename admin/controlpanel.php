<?php
include "admincontrol.php";
include "../header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;"><?php echo $title ?> MAIN ADMIN CONTROL PANEL</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="<?php echo $domain ?>" target="_blank">MAIN WEBSITE</a></td></tr>
<tr><td align="center" colspan="2"><a href="contactsend.php">SEND MANUAL EMAIL TO YOUR PROSPECT LISTS</a></td></tr>
<tr><td align="center" colspan="2"><a href="autorespondercontrol.php">EDIT YOUR AUTORESPONDER SETTINGS</a></td></tr>
<tr><td align="center" colspan="2"><a href="prospectlist.php">PROSPECT/LEAD MANAGEMENT</a></td></tr>
<tr><td align="center" colspan="2"><a href="importcsv.php">IMPORT CSV FILE OF CONTACTS</a></td></tr>
<tr><td align="center" colspan="2"><a href="editpages.php">EDIT PAGE HTML</a></td></tr>
<tr><td align="center" colspan="2"><a href="editlayout.php">EDIT HTML LAYOUT</a></td></tr>
<tr><td align="center" colspan="2"><a href="index.php">LOGOUT</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
?>