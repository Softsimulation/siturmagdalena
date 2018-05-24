<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema de Información Turistica del Magdalena">
        <meta name="author" content="SITUR Magdalena">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <link rel="icon" type="image/ico" href="<?php echo e(asset('/Content/icons/favicon-96x96.png')); ?>" />
        <!--<link href="@Url.Content("/Content/mdl/bootstrap_mdl/css/bootstrap.min.css")" rel="stylesheet" type="text/css" />-->
        <!--<link href="@Url.Content("~/Content/mdl/material.min.css")" rel="stylesheet" type="text/css" />-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('/Content/bootstrap_material/dist/css/bootstrap-material-design.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('/Content/bootstrap_material/dist/css/ripples.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('/Content/sweetalert.css')); ?>" rel='stylesheet' type='text/css' />
        <link href="<?php echo e(asset('/css/select.min.css')); ?>" rel='stylesheet' type='text/css' />
        <link href="<?php echo e(asset('/Content/ionicons/css/ionicons.min.css')); ?>" rel='stylesheet' type='text/css' />
        <link href="<?php echo e(asset('/Content/styleLoading.css')); ?>" rel='stylesheet' type='text/css' />
        <?php echo $__env->yieldContent('estilos'); ?>
        <style>
            html {
                font-size: 16px;
            }
            .banner {
                background-color: white;
                padding-top: 1em;
                padding-bottom: 1em;
                color: dimgray;
                text-align: center;
                font-weight: 700;
            }
            .banner img {
                height: 6em;
            }
            .title-section {
                background-color: dodgerblue;
                color: white;
                width: 100%;
                padding: 4%;
                padding-top: .5em;
                padding-bottom: .5em;
                text-align: center;
                /*margin-bottom: 1em;*/
            }
            .asterik {
                color: red;
                font-size: 1em;
            }
            .checkbox {
                margin-bottom: 0.5em;
            }
            .checkbox label, .radio label {
                color: dimgray;
            }
            .form-group {
                margin: 0;
            }
            
            .table > tbody > tr > td {
                padding-bottom: 0;
                font-weight: 400;
                font-size:16px;
                
            }
            .table > thead > tr > th{
                text-align:center;
                
            }
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
                vertical-align: middle;
            }
            /*.dropdown-menu {*/
            /*    left: -85%;*/
            /*}*/
            .fixed {
                position: fixed;
                top: 0;
                width: 100%;
            }
            .alert-fixed {
            position: fixed; 
            width: 80%;
            top: 2%;
            left: 10%;
            box-shadow: 0px 0px 3px 0px rgba(0,0,0,.5);
            z-index: 10;
            }
            .control-label {
                color:dimgrey!important;
            }
            .label-danger {
                font-size: 1em;
            }
            .progress {
                height: 1.4em;
            }
            .progress-bar {
                font-size: 1.2em;
                font-weight: 500;
                line-height: 1.3em;
            }
            .radio label, label.radio-inline {
                padding-left: 1.8em;
            }
            footer {
                width: 100%;
                background-color: rgba(0,0,0,.35);
                padding: 1em;
                text-align: right;
            }
            #log form {
                float: none!important;
                
            }
            #log form a{
                text-decoration: none;
                color:#333!important;
                font-size: 1em!important;
                font-weight: 400;
                padding: 3px 20px;
            }
            .selectLenguage {
                padding: .2em 1em;
                border-radius: 5px;
                margin-bottom: 1em;
            }
            .tooltip-inner {
                text-align:left !important;
            }
        </style>
        
    </head>
    <body ng-app="encuesta">
        <div id="preloader">
            <div>
                <div class="loader"></div>
                <h1>Cargando</h1>
                <h4>Por favor espere</h4>
                <img src="/Content/image/logo.min.png" width="200" />
            </div>
        </div>
        
        <header>
            <div class="banner">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-2">
                            <img src="/Content/image/logo.png" alt="Logo" />
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <h1 style="margin-top: 0.8em; font-size: 2em"><strong>Encuesta de turismo receptor</strong></h1>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <div class="title-section">
                <h3 style="margin-top: 0.5em;"><strong><?php echo $__env->yieldContent('TitleSection'); ?></strong></h3>
            </div>
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" style="width: <?php echo $__env->yieldContent('Progreso'); ?>"><?php echo $__env->yieldContent('NumSeccion'); ?></div>
            </div>
            
        </header>
        
        <div class="container" <?php echo $__env->yieldContent('controller'); ?>>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        
        <script src="<?php echo e(asset('/js/plugins/angular.min.js')); ?>"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo e(asset('/Content/bootstrap_material/dist/js/material.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/Content/bootstrap_material/dist/js/ripples.min.js')); ?>"></script>
        <script>
            $.material.init();
        </script>
        <script src="<?php echo e(asset('/js/plugins/checklist-model.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/plugins/select.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('/js/plugins/angular-filter.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/plugins/angular-repeat-n.min.js')); ?>"></script>
        
        <script src="<?php echo e(asset('/js/sweetalert.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/dir-pagination.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/encuesta.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/datos_encuestado.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/estanciayvisitados.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/transporte.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/grupo_viaje.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/gasto.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/percepcion_viaje.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/enteran.js')); ?>"></script>
        
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/services/receptorServices.js')); ?>"></script>
        <script src="<?php echo e(asset('/js/encuestas/turismoReceptor/services/grupoViajeServices.js')); ?>"></script>
        
        <script>
            $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
        </script>
        <script>
            $(window).on('scroll', function () {
                
                if ($(this).scrollTop() > 190) {
                
                    $('.alert').addClass('alert-fixed');
                } else {
                    $('.alert').removeClass('alert-fixed');
                }
                
                
            });
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        
        <?php echo $__env->yieldContent('javascript'); ?>
        
        <noscript>Su buscador no soporta Javascript!</noscript>
        
    </body>
</html>