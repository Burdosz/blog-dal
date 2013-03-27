<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>
        </title>
        <?php
        echo $this->Html->meta('icon');

//        echo $this->Html->css('cake.generic');

        $this->Html->loadCSS('front/blog/blog');
        $this->Html->loadJS('jquery-1.9.0');

        $this->Html->loadCSS('bootstrap.min.css');

        $this->Html->loadJS('bootstrap.min.js');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <!-- header -->
        <div id="header">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <?php
                        echo $this->Html->link(
                                'Locust Blog', array(
                            'controller' => 'mypage',
                            'action' => 'index'), array(
                            'class' => 'brand service-title'
                        ));
                        ?>
                        <ul class="nav">
                            <?php
                            $menus = array('マイページ', 'ブログを書く');
                            $actions = array('index', 'newpost');

                            for ($i = 0; $i < count($menus); $i++) {
                                $menu = $menus[$i];
                                $action = $actions[$i];

                                echo '<li>';
                                echo $this->Html->link(
                                        $menu, array(
                                    'controller' => 'mypage',
                                    'action' => $action
                                ));
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row container">
            <div class="span1"></div>
            <div class="span10">
                <div id="container">
                    <div id="header">
                        <h1 id="blog-title">
                            <?php
                            echo $this->Html->link(h($blogTitle), array(
                                'controller' => 'blog',
                                'user' => $userAccount,
                                'action' => 'index')
                            );
                            ?>
                        </h1>
                    </div>
                    <div id="content">

                        <?php echo $this->Session->flash(); ?>

                        <?php echo $this->fetch('content'); ?>
                    </div>
                    <div id="footer">
                    </div>
                </div>
            </div>
            <div class="span1"></div>
        </div>
        <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>
