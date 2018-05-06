<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <title><?php echo ucwords($title)."";?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
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


        
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/datepicker3.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/bootstrap-timepicker.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/iosCheckbox.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/bootstrap-select.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/ajax-bootstrap-select.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/jquery.autocomplete.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/jquery.lightbox-0.5.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/jquery.webui-popover.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/bootstrap-horizon.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/jquery-confirm.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/animate.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/lightgallery.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/summernote/dist/summernote.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/export-amchart/export.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/css/jquery.videocontrols.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/croppie.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/notification.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/justifiedGallery.min.css" rel="stylesheet">
        
        <!--DATA TABLES-->
        <link href="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/css/jquery.dataTables.css" rel="stylesheet"/>
        <link href="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/css/buttons.dataTables.min.css" rel="stylesheet"/>

        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/manual.css">

        <script>
            var config = {
                 base: "<?php echo base_url(); ?>"
            };
        </script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.formatCurrency-1.4.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/application.js?$$REVISION$$"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-timepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tokeninput.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/blur.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.jqdock.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.sticky.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/ajax-bootstrap-select.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.lightbox-0.5.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.webui-popover.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-confirm.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/lightgallery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/lg-fullscreen.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/lg-thumbnail.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/summernote/dist/summernote.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/sticky-scroll/theia-sticky-sidebar.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.price_format.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.videocontrols.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/croppie.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/html2json.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/htmlparser.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/moment-timezone.min.js"></script>
        

        
        <!--DATA TABLES-->
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/js/dataTables.buttons.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/js/jszip.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/js/buttons.print.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/js/pdfmake.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/js/vfs_fonts.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/DataTables/DataTables-1.10.9/js/buttons.html5.js"></script>

        <!-- AmCharts -->
        <script src="<?php echo base_url();?>assets/js/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/amcharts/pie.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/export-amchart/export.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/amcharts/gauge.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/grafik.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/html2canvas.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/rgbcolor.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/StackBlur.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/canvg.js"></script>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/socket.io.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeago.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.justifiedGallery.min.js"></script>


        
        <script type="text/javascript">
            $(document).ready(function() {
                $('.column').theiaStickySidebar({additionalMarginTop: 76});
                $('[data-toggle="tooltip"]').tooltip(); 

                // Bootstrap Datepicker Defaults
                $.fn.datepicker.defaults.autoclose = true;
            });

        </script>

        <link href="<?php echo base_url();?>assets/css/shared.css" rel="stylesheet"/>
        <link rel="stylesheet" href="<?=base_url()?>assets/template/css/manual.css">
    </head>
    
    <body>
        <div id="modal_finder"></div>
        <div class="page">
            <!--=============================== Header ===========================-->
            <div id="header">
                <?=$header?>
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
