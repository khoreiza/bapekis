<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo ucwords($title);?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?=base_url()?>assets/img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?=base_url()?>assets/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>assets/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url()?>assets/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url()?>assets/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url()?>assets/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>assets/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?=base_url()?>assets/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>assets/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?=base_url()?>assets/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?=base_url()?>assets/img/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?=base_url()?>assets/img/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/manual.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/animate.css" type="text/css">
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/owlcarousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/owlcarousel/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/bootstrap-responsive.min.css">
        
                
        <!-- Google fonts Poppins -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Fontello -->
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/css-fontello/animation.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/css-fontello/fontello.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/css-fontello/fontello-codes.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/css-fontello/fontello-embedded.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/css-fontello/fontello-ie7.css" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/css-fontello/fontello-ie7-codes.css" type="text/css"/>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php echo $this->load->view('admin/shared/first/component/header/_css','',TRUE);?>
        <link rel="stylesheet" href="<?=base_url()?>assets/css/shared.css" type="text/css"/>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
        <script>
            var config = {
                 base: "<?php echo base_url(); ?>"
            };
        </script>

        <!-- JS code --> 
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="<?=base_url()?>assets/template/js/bootstrap.min.js"></script>

        <?php if($this->uri->segment(1) != "admin"){?>
               
        <script src="<?=base_url()?>assets/template/js/jquery.spincrement.js"></script>
        <script src="<?=base_url()?>assets/template/js/owl.carousel.min.js"></script>
        <script src="<?=base_url()?>assets/template/js/scrollBar.js"></script>
        
        <script src="<?=base_url()?>assets/template/js/myScript.js"></script>

        <?php }?>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/application.js"></script>



        <div class="page">
            <!--=============================== Header ===========================-->
            <div id="header">
                <?=$header?>
            </div>

            <!--=============================== Menu-Bar ========================-->
            <div id="menuBar-charity">
                <?=(isset($menu)) ? $menu : ""?>
            </div>

            <!--=============================== Content ========================-->
            <?=(isset($content)) ? $content : ""?>

            <!--=============================== Footer ===========================-->
            <div id="footer">
                <?=$footer?>
            </div>
        </div>
    </body>
</html>
