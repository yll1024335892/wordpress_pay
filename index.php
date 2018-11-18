<?php
/**
 * User: yinliangliang
 * Date: 2018/11/18
 * Time: 23:25
 * file: index.php
 * email:yll1024335892@163.com
 */

    echo "wordpress的一个简单的模板创建成功！";
?>

<form name=alipayment action=http://www.wordpay.com/efhl/alipay method=post target="_blank">
    <div id="body1" class="show" name="divcontent">
        <dl class="content">
            <dt>商户订单号
                ：</dt>
            <dd>
                <input id="WIDout_trade_no" name="WIDout_trade_no" />
            </dd>
            <hr class="one_line">
            <dt>订单名称
                ：</dt>
            <dd>
                <input id="WIDsubject" name="WIDsubject" />
            </dd>
            <hr class="one_line">
            <dt>付款金额
                ：</dt>
            <dd>
                <input id="WIDtotal_amount" name="WIDtotal_amount" />
            </dd>
            <hr class="one_line">
            <dt>商品描述：</dt>
            <dd>
                <input id="WIDbody" name="WIDbody" />
            </dd>
            <hr class="one_line">
            <dt></dt>
            <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">付 款</button>
                        </span>
                <span class="note-help">如果您点击“付款”按钮，即表示您同意该次的执行操作。</span>
            </dd>
        </dl>
    </div>
</form>
<script language="javascript">

    function GetDateNow() {
        var vNow = new Date();
        var sNow = "";
        sNow += String(vNow.getFullYear());
        sNow += String(vNow.getMonth() + 1);
        sNow += String(vNow.getDate());
        sNow += String(vNow.getHours());
        sNow += String(vNow.getMinutes());
        sNow += String(vNow.getSeconds());
        sNow += String(vNow.getMilliseconds());
        document.getElementById("WIDout_trade_no").value =  sNow;
        document.getElementById("WIDsubject").value = "测试";
        document.getElementById("WIDtotal_amount").value = "0.01";
    }
    GetDateNow();
</script>
