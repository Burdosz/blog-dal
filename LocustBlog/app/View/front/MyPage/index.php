<?php
$this->Html->loadCSS('front/mypage/index');
$this->Html->loadJS('front/mypage/index');
?>
<h1>MyPage</h1>

<ul>
    <?php
    // ブログ投稿
    echo '<li>';
    echo $this->Html->link('ブログを書く', 'newpost');
    echo '</li>';
    
    // 記事リスト
    echo '<li>';
    echo $this->Html->link('投稿の編集、削除', 'postlist');
    echo '</li>';
    
    // カテゴリ編集
    echo '<li>';
    echo $this->Html->link('カテゴリの編集', 'categoryList');
    echo '</li>';
    ?>  

</ul>




