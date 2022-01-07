<?php include_once "../base.php";

$news=$News->find($_POST['nesws']);
$type=$_POST['type'];

switch($type){
    case 1://收回讚
        $Log->del(['news'=>$news,'user'=>$_SESSION['login']]);
        $post['good']--;
        $News->save($news);
    break;
    case 2://讚
        $Log->save(['news'=>$news,'user'=>$_SESSION['login']]);
        $post['good']++;
        $News->save($news);
    break;
}

