<?php include_once "../base.php";
$acc=$_POST['acc'];
$pw=$_POST['pw'];
$chk=$User->math('count','*',['acc'=>$acc,'pw'=>$pw]);

if($chk>0){
    echo 1;
    $_SESSION['login']=$acc;
}else{
    echo 0;
}