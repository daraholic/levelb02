<?php include_once "../base.php";

$type=$_GET['type'];
$news=$News->all(['type'=>$type]);

foreach ($news as $key => $value) {
    echo "<p><a href='#' onclick='getnews({$value['id']})'>";
    echo $value['title'];
    echo "</a></p>";
}