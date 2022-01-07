<?php include_once "../base.php";

$id=$_GET['id'];
$news=$News->find($id);

//new line to br
echo nl2br($news['text']);
