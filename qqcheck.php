<?php
include("./includes/common.php");

$qq=daddslashes($_GET['qq']);

$row=$DB->get_row("SELECT * FROM auth_site WHERE qq='$qq' and active=1 limit 1");
if($row)
	echo '1';
else
	echo '0';
$DB->close();
?>