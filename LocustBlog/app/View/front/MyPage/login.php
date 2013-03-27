<!--
<form action="login" method="post">

    <table>
        <tr>
            <td>アカウント</td><td><input type="text" name="data[User][account]" id="UserAccount" /></td>
        </tr>
        <tr>
            <td>パスワード</td><td><input type="password" name="data[User][password]" id="UserPassword" /></td>
        </tr>
    </table>

    <input type="submit" value="ログイン" />
</form>
-->
<?php
echo $this->Form->create(false, array('type' => 'post', 'action' => 'login',));
?>
<table>
        <tr>
            <td>アカウント</td><td><?php echo $this->Form->input('User.account', array('type' => 'text', 'label' => false, 'class' => 'max-width')) ?></td>
        </tr>
        <tr>
            <td>パスワード</td><td><?php echo $this->Form->input('User.password', array('type' => 'password', 'label' => false,  'class' => 'max-width')) ?></td>
        </tr>
    </table>
<?php
echo $this->Form->end('ログイン');
?>