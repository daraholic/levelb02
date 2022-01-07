<fieldset>
    <legend>目前位置：首頁 > 人氣文章區</legend>
<table>
    <tr>
        <td width="30%">標題</td>
        <td width="50%">內容</td>
        <td>人氣</td>
    </tr>
    <?php
    $tarray=[
        "1"=>"健康新知",
        "2"=>"菸害防治",
        "3"=>"癌症防治",
        "4"=>"慢性病防治",
    ];
    
    $total=$News->math("count","*");
    $div=5;
    $pages=ceil($total/$div);
    $now=$_GET['p']??1;
    $start=($now-1)*$div;

    $rows=$News->all(['sh'=>1]," order by `good` desc limit $start,$div");
    foreach ($rows as $key => $row) {
    ?>
    <tr>
        <td class="switch"><?=$row['title'];?></td>
        <td class="switch">
            <div class="short"><?=mb_substr($row['text'],0,20);?>...</div>
            <div class="pop">
                <h2 style='color:skyblue'><?=$tarray[$row['type']];?></h2>
                <?=nl2br($row['text']);?>
            </div>
        </td>
        <td>
            <?=$row['good'];?>個人說<img src='icon/02B03.jpg' style='width:25px'>
            -<?php
                if(isset($_SESSION['login'])){
                    $chk=$Log->math('count','*',['news'=>$row['id'],'user'=>$_SESSION['login']]);
                    if($chk>0){
                        echo "<a class='g' data-news='{$row['id']}' data-type='1'>收回讚</a>";
                    }else{
                        echo "<a class='g' data-news='{$row['id']}' data-type='2'>讚</a>";
                    }
                }

            ?>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
<div>
<?php

if(($now-1)>0){
    $prev=$now-1;
    echo "<a href='index.php?do=news&p=$prev'> ";
    echo " < ";
    echo " </a>";
}


for($i=1;$i<=$pages;$i++){
    $font=($now==$i)?'24px':'16px';
    echo "<a href='index.php?do=pop&p=$i' style='font-size:$font'> ";
    echo $i;
    echo " </a>";
}

if(($now+1)<=$pages){
    $next=$now+1;
    echo "<a href='index.php?do=pop&p=$next'> ";
    echo " > ";
    echo " </a>";
}

?>
</div>
</fieldset>
<script>
$(".switch").hover(
    function(){
    $(this).parent().find(".short,.full").toggle()
})
$(".g").on("click",function(){
        let type=$(this).data('type')
        let news=$(this).data('news')
    $.post("api/good.php",{type,news},()=>{
        location.reload()
/*         switch(type){
            case 1:
               $(this).text("讚");
               $(this).data('type',2)
            break;
            case 2:
                $(this).text("收回讚");
                $(this).data('type',1)
            break;
        } */
    })
})

</script>