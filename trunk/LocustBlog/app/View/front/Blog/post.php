<div class="entry-link">
    <?php
    $this->Html->loadCSS('front/blog/post');

    function writeLink($view, $userAccount, $prev, $next) {

        echo '<div class="row">';
        echo '<div class="span3">';
        if ($next) {
            echo $view->Html->link(
                    '<< ' . $view->Text->truncate($next['Post']['title'], 20), array(
                'controller' => 'blog',
                'user' => $userAccount,
                'post_id' => $next['Post']['id'],
                'action' => 'entry')
            );
        }
        echo '</div>';
        echo '<div class="span4"></div>';
        echo '<div class="span3 next_link">';
        if ($prev) {
            echo $view->Html->link(
                    $view->Text->truncate($prev['Post']['title'], 20) . ' >>', array(
                'controller' => 'blog',
                'user' => $userAccount,
                'post_id' => $prev['Post']['id'],
                'action' => 'entry')
            );
        }
        echo '</div>';
    }

    writeLink($this, $userAccount, $prev, $next);
    ?>
</div>
<div class="entry">
    <h4 class="title">
        <?php echo h($post['Post']['title']); ?>
    </h4>
    <hr/>
    <p class="category">カテゴリ:
        <?php echo h($post['Category']['category_name']); ?>
    </p>
    <div>
        <pre><?php echo h($post['Post']['content']); ?></pre>
    </div>
    <hr/>
</div>

<div class="entry-link">
    <?php writeLink($this, $userAccount, $prev, $next); ?>
</div>