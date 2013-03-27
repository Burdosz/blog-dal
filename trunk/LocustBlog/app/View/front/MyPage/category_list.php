<h1>カテゴリ編集</h1>

<?php
echo $this->Form->create(false, array('type' => 'post', 'action' => 'addCategory'));
echo $this->Form->input('new_category', array('type' => 'text', 'label' => '新しいカテゴリ'));
echo $this->Form->hidden('token', array('value' => $token));
echo $this->Form->end('追加');
?>

<table>
    <tr>
        <th>カテゴリ名</th>
    </tr>
    <?php
    foreach ($categories as $category) {
        echo '<tr>';

        echo '<td>'
        . $this->Html->link(
                $category->getCategoryName(), 
                array(
                    'controller' => 'mypage',
                    'action'     => 'editCategory',
                    '?'          => array('category' => $category->getId())
                ))
        . '</td>';


        echo '</tr>';
    }
    ?>
</table>

<?php
if ($this->Paginator->hasPage(2)) {
    echo '<div id="paging_count">';
    echo $this->Paginator->counter();
    echo '</div>';
    echo '<div id="paging">';
    echo $this->Paginator->prev('< 前へ');
    echo '<span style="margin-left:10px;margin-right:10px;">';
    echo $this->Paginator->numbers();
    echo '</span>';
    echo $this->Paginator->next(' 次へ >');
    echo '</div>';
}
?>