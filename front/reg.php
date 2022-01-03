<fieldset>
    <legend>會員註冊</legend>
    <div style="color: red;">*請設定您要註冊的帳號及密碼(最長12個字元)</div>
    <!-- table>tr*5>td*2 -->
    <table>
        <tr>
            <td>Step1:登入帳號</td>
            <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
            <td>Step2:登入密碼</td>
            <td><input type="password" name="pw" id="pw"></td>
        </tr>
        <tr>
            <td>Step3:再次確認密碼</td>
            <td><input type="password" name="pw2" id="pw2"></td>
        </tr>
        <tr>
            <td>Step4:信箱(忘記密碼時使用)</td>
            <td><input type="text" name="email" id="email"></td>
        </tr>
        <tr>
            <td>
                <button onclick="reg()">註冊</button>
                <button onclick="reset()">清除</button>
            </td>
            <td></td>
        </tr>
    </table>
</fieldset>
<script>
    function reset() {
        // 取id的值
        $("#acc,#pw,#pw2,#email").val("")
    }

    function reg() {
        let form = {
            acc: $("#acc").val(),
            pw: $("#pw").val(),
            pw2: $("#pw2").val(),
            email: $("#email").val()
        }
        // 判斷是否有空白的高端寫法:
        // if(Object.values(form).indexOf('')>=0){
            // alert("不可空白")
        // }
        if (form.acc == '' || form.pw == '' || form.pw2 == '' || form.email == '') {
            alert("不可空白")
        } else {
            // 密碼確認
            if (form.pw!=form.pw2) {
                alert("密碼錯誤")
            } else {
                $.post("api/chk_acc.php", {acc: form.acc}, (chk) => {
                    // parseInt()字串轉數字
                    if (parseInt(chk) == 1) {
                        alert("帳號重複")
                    } else {
                        delete form.pw2
                        // console.log(res)
                        $.post("api/reg.php",form,(res)=> {
                            // if(parseInt(res)==1){
                                alert("註冊完成,歡迎加入")
                                location.href='index.php?do=login'
                            // }else{
                            //     alert("註冊失敗")
                            // }
                        })
                    }
                })


            }

        }

    }
</script>