<h1>カテゴリ編集</h1>

<?php
echo $this->Form->create(false, array('type' => 'post', 'action' => 'updateCategory'));
echo $this->Form->input(
        'category_name', 
        array(
            'type' => 'text',
            'value' => $category->getCategoryName()
        )
);
echo $this->Form->hidden('token', array('value' => $token));
echo $this->Form->end('更新');
?>