<?php
$this->Html->loadCSS('front/blog/home');
$this->Html->loadJS('front/blog/home');

foreach ($post as $data) {
    ?>
    <div class="entry">
        <h4 class="title">
            <?php
            echo $this->Html->link($data['Post']['title'], array(
                'controller' => 'blog',
                'user' => $userAccount,
                'post_id' => $data['Post']['id'],
                'action' => 'entry')
            );
            ?>
        </h4>
        <hr/>

        <p class="category">カテゴリ:
            <?php
            echo $this->Html->link(
                    $data['Category']['category_name'], array(
                'controller' => 'blog',
                'user' => $userAccount,
                'action' => 'index',
                '?' => array('category' => $data['Category']['id']
                    ))
            );
            ?> 
        </p>
        <div>
            <pre><?php echo h($data['Post']['content']); ?></pre>
        </div>
        <hr/>
    </div>
    <?php
}

if ($this->Paginator->hasPage(2)) {
    // urlにユーザー名を入れるためにオプションを設定(routesで設定してる項目名に値を設定)
    $this->Paginator->options(array('url' => array('user' => $userAccount)));

    $option = $searchCategory ? array('onclick' => 'addCategoryToLink(this)') : array();

    echo '<div id="paging_count">';
    echo $this->Paginator->counter();
    echo '</div>';
    echo '<div id="paging">';
    ;
    echo $this->Paginator->prev('< 前へ', $option);
    echo '<span style="margin-left:10px;margin-right:10px;">';
    echo $this->Paginator->numbers($option);
    echo '</span>';
    echo $this->Paginator->next(' 次へ >', $option);
    echo '</div>';
}
?>