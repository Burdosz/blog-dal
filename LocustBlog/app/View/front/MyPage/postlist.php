<?php
App::uses('Util', 'Lib/Common');

$this->Html->loadCSS('front/mypage/postlist');
?>

<div id="month_list">

    <div id="year">
        <?php
        // 前の年へのリンク
        if (checkdate(1, 1, $year - 1)) {
            echo $this->Html->link(
                    '<< ', array(
                'controller' => 'mypage',
                'action' => 'postlist',
                '?' => array('year' => ($year - 1), 'month' => $month)
                    ), array('class' => 'year')
            );
        }

        echo $year . '年';

        $currentDate = Util::getDate();

        // 次の年へのリンク
        if (checkdate(1, 1, $year + 1) && $currentDate['year'] > intval($year)) {
            echo $this->Html->link(
                    ' >>', array(
                'controller' => 'mypage',
                'action' => 'postlist',
                '?' => array('year' => ($year + 1), 'month' => $month)
                    ), array('class' => 'year')
            );
        } 
        ?>
    </div>
        <?php
        for ($i = 0; $i < 12; $i++) {

            if ($i + 1 != $month) {
                echo $this->Html->link(
                        ($i + 1) . '月', array(
                    'controller' => 'mypage',
                    'action' => 'postlist',
                    '?' => array(
                        'year' => $year,
                        'month' => ($i + 1))),
                        array('class' => 'month')
                );
            } else {
                echo '<span class="selected">' . ($i + 1) . '月</span>';
            }

            if ($i != 11) {
                echo '<span class="divider"></span>';
            } 
        }
        ?>
</div>


<h1>記事の編集・削除</h1>

<?php
if (empty($posts)) {
    echo 'この月に投稿した記事はありません。';
} else {

    echo '<table class="table table-striped">';
    foreach ($posts as $post) {
        echo '<tr>';
        echo '<td>' . $post->getTitle() . '</td>';
        echo '<td>';
        echo $this->Html->link(
                '編集', array(
            'controller' => 'mypage',
            'action' => 'editpost',
            '?' => array(
                'id' => $post->getId()
            ))
        );
        echo '</td>';
        echo '<td>';
        echo $this->Html->link(
                '削除', 
                array(
                    'controller' => 'mypage',
                    'action' => 'deletepost',
                    '?' => array(
                        'id' => $post->getId(),
                        'token' => $token
                        )
                    ),
                array(
                    'onclick' => 'return confirm("削除しますか？");'
                )
        );
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>

<table>
    
</table>