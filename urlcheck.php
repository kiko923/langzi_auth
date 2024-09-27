<?php
include("./includes/common.php");
$url=daddslashes($_GET['url']);

if($url && checkauth2($url)) {
	echo '1';
} else {
	echo '0';
}

$DB->close();
?>