<?php
ini_set('display_errors', 0);

$root = 2084310194;
$name = "日本刀、刀剣";
$title_name = "刀剣";
$this_url = 'http://tiger4th.com/sword/';

$contents = "";
ob_start();
include('./app_id.php');
include('./logic.php');
include('./template.php');
$contents = ob_get_contents();
ob_end_clean();
echo $contents;
?>