<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>
        </title>
        <?php
        echo $this->Html->meta('icon');

//        echo $this->Html->css('cake.generic');

        $this->Html->loadCSS('front/mypage/mypage.css');
        $this->Html->loadCSS('bootstrap.min.css');
//        $this->Html->loadCSS('bootstrap-responsive.min.css');
        $this->Html->loadJS('bootstrap.min.js');
        $this->Html->loadJS('jquery-1.9.0.js');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body class="container">
        <h1 class="service-title">Locust Blog</h1>
        
        <!-- タブメニュー -->
        <ul class="nav nav-tabs">
            <li class="active">
                <?php 
                    echo $this->Html->link(
                            'ブログを書く', 
                            'newpost',
                            array('data-toggle' => 'tab'));
                ?>
            </li>
        </ul>
        
        <div class="row">
            <div class="span12 menu-title">
                <h5>ブログ管理</h5>
            </div>
        </div>
        <!-- サイドメニュー -->
        <div class="row">
            <div class="span3">
                <div class="well">
                    <ul class="nav nav-list">
                        <?php
                        $actions = array('newpost', 'postlist', 'categoryList');
                        $titles = array('ブログを書く', '投稿の編集、削除', 'カテゴリの編集');

                        for ($i = 0; $i < count($actions); $i++) {
                            $action = $actions[$i];
                            $title = $titles[$i];

                            // ブログ投稿
                            if ($this->request->params['action'] == $action) {
                                echo '<li class="active">';
                            } else {
                                echo '<li>';
                            }

                            echo $this->Html->link($title, $action);
                            echo '</li>';
                        }

                        ?>
                    </ul>
                </div>
            </div>
            <!--<div class="span1"></div>-->
            <div class="span9">
                <div id="container">
                    <div id="header">
                    </div>
                    <div id="content">

                        <?php echo $this->Session->flash(); ?>

                        <?php echo $this->fetch('content'); ?>
                    </div>
                    <div id="footer">
                    </div>
                </div>
            </div>
        </div>
        <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>
