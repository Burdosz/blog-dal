<h1>投稿内容確認</h1>

<table>
    <tr>
        <td>タイトル</td>
        <td><?php echo h($title); ?></td>
    </tr>
    <tr>
        <td>カテゴリ</td>
        <td><?php echo h($category->getCategoryName()); ?></td>
    </tr>
</table>

<div>
    <pre><?php echo h($content); ?></pre>
</div>

<!--
<form action="publish" method="post">
    <input type="hidden" name="token" value="
<?php
//echo $token;
?>" />
    <input type="submit" value="公開" />
</form>
-->

<?php
echo $this->Form->create(false, array('type' => 'post', 'action' => 'publish'));
echo $this->Form->hidden('token', array('value' => $token));
echo $this->Form->end('公開');

?>