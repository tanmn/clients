<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

    <head>
        <?php echo $this->Html->charset(); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <?php echo $this->Html->meta('icon'); ?>

        <title><?php echo $title_for_layout; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <?php
            echo $this->fetch('meta');

            echo $this->Html->css('bs.min');
            echo $this->Html->css('bs-theme.min');
            echo $this->Html->css('main');
            echo $this->fetch('css');

            echo $this->Html->script('vendor/modernizr-2.6.2-respond-1.1.0.min');
            echo $this->Html->script('vendor/jquery-1.10.1.min');
        ?>

        <script type="text/javascript">
            var BASE = '<?php echo Router::url('/', TRUE); ?>';
            var APIS = '<?php echo Router::url('/Apis/', TRUE); ?>';
        </script>
    </head>

    <body id="wrapper" class="homepage">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <?php
            $custom_header = $this->fetch('header');
            if(!empty($custom_header)){
                echo $custom_header;
            }else{
                echo $this->Element('global_header');
            }
        ?>

        <div id="content" class="container">
            <div class="row-fluid">
                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
        </div>

        <?php echo $this->Element('global_download'); ?>

        <footer>
            <?php
                $custom_footer = $this->fetch('footer');
                if(!empty($custom_footer)){
                    echo $custom_footer;
                }else{
                    echo $this->Element('global_footer');
                }
            ?>
        </footer>

        <?php
            echo $this->Html->script('vendor/bootstrap.min');
            echo $this->fetch('script');
            echo $this->Html->script('plugins');
            echo $this->Html->script('main');
        ?>
    </body>
</html>