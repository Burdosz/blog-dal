<h4>ブログを書く</h4>

<?php echo $this->Form->create(false, array('type' => 'post', 'action' => 'confirm'));
; ?>
<table>
    <tr>
        <td>タイトル</td>
        <td>
            <?php
            echo $this->Form->input(
                    'title', 
                    array('type' => 'text', 'label' => false)
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
                $options[$category['Category']['id']]
                        = $category['Category']['category_name'];
            }

            echo $this->Form->select(
                    'category', 
                    $options, 
                    array('empty' => false)
            );
            ?>
        </td>
    </tr>
</table>

<?php 

echo $this->Form->textarea('content', array('cols' => 20, 'rows' => 10, 'class' => 'max-width')); 

// hidden
// token
echo $this->Form->hidden(
        'token', 
        array('value' => $token));

// submit
echo $this->Form->end(array('label' => '確認', 'class' => 'btn btn-info'));
?>