<h4>ブログを編集する</h4>

<?php echo $this->Form->create(false, array('action' => 'updatepost')); ?>
<table class="max-width">
    <tr>
        <td>タイトル</td>
        <td>
            <?php
            echo $this->Form->input(
                    'title', 
                    array(
                        'type' => 'text', 
                        'value' => $post->getTitle(), 
                        'label' => false,
                        'class' => 'max-width'
                        )
                    );
            ?>
        </td>
    </tr>
    <tr>
        <td>カテゴリ</td>
        <td>
            <?php
            // CSRF対策にSecurityコンポーネントを使うのでForm
            // ヘルパーでフォームを作る
            $options = array();

            foreach ($categories as $category) {
                $options[$category->getId()]
                        = $category->getCategoryName();
            }
            echo $this->Form->input(
                    'category', 
                    array(
                        'type' => 'select',
                        'label' => false, 
                        'options' => $options,
                        'empty' => false, 
                        'default' => $post->getCategoryId()
                    )
            );
            ?>
        </td>
    </tr>
</table>

<?php
echo $this->Form->textarea('content', array('cols' => 20, 'rows' => 10, 'class' => 'max-width', 'value' => h($post->getContent())));
echo $this->Form->end(array('label' => '更新', 'class' => 'btn btn-info'));
?>