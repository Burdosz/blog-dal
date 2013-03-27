<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->script('front/signup/index'); ?>

        <script type="text/javascript" src="/js/front/signup/index"></script>
    </head>
    <body>
        <h3>メールアドレスの登録</h3>

        <form action="sendMail" method="POST" id="form">
            <table class="table table-bordered">
                <tr>
                    <td>PCメールアドレス</td>
                    <td><input type="email" id="email" name="email" placeholder="ここに入力" /></td>
                </tr>
            </table>
            <button onclick="checkEmail();" class="btn btn-primary"><i class="icon-envelope icon-white" style="margin-top: 1px;"></i> 確認メールを送信</button>
        </form>
    </body>
</html>