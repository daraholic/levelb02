<fieldset>
    <legend>帳號管理</legend>
    <form action="api/">
    <table class="ct" style="width: 75%;margin:auto;">
        <tr class="clo">
            <td>帳號</td>
            <td>密碼</td>
            <td width="10%">刪除</td>
        </tr>
        <?php
        $users=$User->all();
        foreach ($users as $key =>$user){

       
        ?>
        <tr>
            <td><?=$user['acc'];?></td>
            <td><?=str_repeat("*",mb_strlen($user['pw']));?></td>
            <td><input type="checkbox" name="del[]" value="<?=$user['id'];?>"></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <div>
        <input type="text">
    </div>
</form>
</fieldset>