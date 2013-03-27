<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>
        </title>
        <?php
        echo $this->Html->meta('icon');

//        echo $this->Html->css('cake.generic');
//        $this->Html->loadCSS('front/mypage/mypage.css');
        $this->Html->loadCSS('bootstrap.min.css');
        $this->Html->loadCSS('front/signin/signin.css');
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
        <hr/>
        <div id="container" class="container">
            <div id="header">
            </div>
            <div id="content">
                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
            </div>
        </div>
        <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>
