<?php
/**
 * Created by PhpStorm.
 * User: jsalgado
 * Date: 23/08/2017
 * Time: 11:56
 * @var $content string
 */

use app\assets\AppAsset;
use app\models\app\Menus;
use app\components\Tools;
use kartik\icons\Icon;
use kartik\helpers\Html;
use kartik\widgets\AlertBlock;
use kartik\widgets\Growl;

Icon::map($this, Icon::FA);
factorenergia\adminlte\assets\Asset::register($this);
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php $this->head() ?>
    </head>
    <!--
    BODY TAG OPTIONS:
    =================
    Apply one or more of the following classes to get the
    desired effect
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
    -->
    <body class="hold-transition skin-blue-light sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            <span class="nombreApp <?= Yii::$app->params['environment']; ?>">WebCom</span>
            <!-- Logo -->

            <?php

            echo Html::a(
                Html::tag('span',
                    Html::tag('b', 'f', ['class' => 'factor']) .
                    Html::tag('span', 'e', ['class' => 'energia']),
                    ['class' => 'logo-mini']
                ) .
                Html::tag('span',
                    Html::tag('b', 'factor', ['class' => 'factor']) .
                    Html::tag('span', 'energia', ['class' => 'energia']),
                    ['class' => 'logo-lg']
                ),
                ['/site/index'],
                ['class' => 'logo']
            );
            $menuItems = [
                [
                    'label' => (!Yii::$app->user->isGuest)?Icon::show('user-circle-o', ['style' => 'font-size:25px;'],
                            Icon::FA) . Yii::$app->user->identity->name:'',
                    'encode' => false,
                    'items' => [

                        Html::tag('li',
                            Html::a(Icon::show('sign-out') . 'Desconectar', ['/site/logout'], [
                                'data' => [
                                    'method' => 'POST',
                                ]
                            ])
                        ),

                    ],
                    'visible' => !Yii::$app->user->isGuest
                ],
                [
                    'label' => Icon::show('gears', [], Icon::FA),
                    'encode' => false,
                    'options' => [
                        'title' => 'Seleccionar Empresa',
                        'data' => [
                            'tooltip' => true,
                            'placement' => "bottom",
                            'toggle' => 'control-sidebar'
                        ]
                    ]
                ]
            ];

            echo Html::beginTag('nav', ['class' => 'navbar navbar-static-top', 'role' => 'navigation']);
            echo Html::a(
                Html::tag('span', 'Toggle navigator', ['class' => 'sr-only']),
                '#',
                ['class' => 'sidebar-toggle', 'data' => ['toggle' => 'push-menu'], 'role' => 'button']
            );
            echo Html::beginTag('div', ['class' => 'navbar-custom-menu']);
            echo \yii\bootstrap\Nav::widget([
                'items' => $menuItems,
                'options' => ['class' => 'navbar-nav']
            ]);

            echo Html::endTag('div');
            echo Html::endTag('nav');
            ?>

        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar Menu -->
                <?=
                \factorenergia\adminlte\widgets\Menu::widget(
                    [
//                    'options' => [
//                        'data' => [
//                            'widget' => 'tree'
//                        ]
//                    ],
                        'menuSearching' => true,
                        "items" => [
                            [
                                'icon' => 'home',
                                'label' => 'Inicio',
                                'url' => ['/'],
//                          'url' => Yii::$app->params['webcomUrl'],
                            ],
                            [
                                'label' => 'Calendario',
                                'icon' => 'calendar',
                                'url' => '#',
                                'items' => [
                                    [
                                        'label' => 'Solicitar Vacaciones',
                                        'url' => ['/gestion/calendario/solicitud'],
                                    ],
                                    [
                                        'label' => 'Solicitar Peticiones',
                                        'url' => ['/gestion/calendario/peticiones'],
                                    ],
                                    [
                                        'label' => 'Calendario Propio',
                                        'url' => ['/gestion/calendario/propio'],
                                    ],
                                    [
                                        'label' => 'Calendario del Departamento',
                                        'url' => ['/gestion/calendario/departamento'],
                                    ],

                                ]
                            ],
                        ],
                    ]
                )
                ?>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <?= $content ?>
                <?php
                echo AlertBlock::widget([
                    'useSessionFlash' => true,
                    'type' => AlertBlock::TYPE_GROWL,
                    'delay' => 1000,
                    'alertSettings' => [
                        'error' => [
                            'options' => [
                                'class' => 'col-xs-11 col-sm-3 growlAlertBlock'
                            ],
                            'pluginOptions' => [
                                'offset' => 80,
                                'showProgressbar' => false,
                                'timer' => false,
                                'placement' => [
                                    'from' => 'top',
                                    'align' => 'right',
                                ],
                            ],
                            'type' => Growl::TYPE_DANGER,
                            'icon' => 'fa fa-times fa-15x',
                            'showSeparator' => true,
                        ],
                        'success' => [
                            'options' => [
                                'class' => 'col-xs-11 col-sm-3 growlAlertBlock'
                            ],
                            'pluginOptions' => [
                                'offset' => 80,
                                'showProgressbar' => true,
                                'placement' => [
                                    'from' => 'top',
                                    'align' => 'right',
                                ],
                            ],
                            'type' => Growl::TYPE_SUCCESS,
                            'icon' => 'fa fa-check-square-o fa-15x',
                            'showSeparator' => true,
                        ],
                        'info' => [
                            'options' => [
                                'class' => 'col-xs-11 col-sm-3 growlAlertBlock'
                            ],
                            'pluginOptions' => [
                                'offset' => 80,
                                'showProgressbar' => false,
                                'timer' => false,
                                'placement' => [
                                    'from' => 'top',
                                    'align' => 'right',
                                ],
                            ],
                            'type' => Growl::TYPE_INFO,
                            'icon' => 'fa fa-info-circle fa-15x',
                            'showSeparator' => true,
                        ],
                        'warning' => [
                            'options' => [
                                'class' => 'col-xs-11 col-sm-3 growlAlertBlock'
                            ],
                            'pluginOptions' => [
                                'offset' => 80,
                                'showProgressbar' => false,
                                'timer' => false,
                                'placement' => [
                                    'from' => 'top',
                                    'align' => 'right',
                                ],
                            ],
                            'type' => Growl::TYPE_WARNING,
                            'icon' => 'fa fa-exclamation-triangle fa-15x',
                            'showSeparator' => true,
                        ],
                        'infoEstadoErroresKO' => [
                            'options' => [
                                'class' => 'col-xs-11 col-sm-3 growlAlertBlock errorAlert',
                                'style' => 'color: #a94442;background-color: #f2dede;border-color: #ebccd1;',
                            ],
                            'pluginOptions' => [
                                'offset' => 80,
                                'showProgressbar' => false,
                                'timer' => false,
                                'placement' => [
                                    'from' => 'bottom',
                                    'align' => 'right',
                                ],
                            ],
                            'type' => Growl::TYPE_CUSTOM,
                            'showSeparator' => true,
                        ],
                        'infoEstadoErroresOK' => [
                            'options' => [
                                'class' => 'col-xs-11 col-sm-3 growlAlertBlock successAlert',
                                'style' => 'color: #3c763d;background-color: #dff0d8;border-color: #d6e9c6;',
                            ],
                            'pluginOptions' => [
                                'offset' => 80,
                                'showProgressbar' => false,
                                'timer' => false,
                                'placement' => [
                                    'from' => 'bottom',
                                    'align' => 'right',
                                ],
                            ],
                            'type' => Growl::TYPE_CUSTOM,
                            'showSeparator' => true,
                        ],
                    ]
                ]);
                ?>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                v.0.0.0
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy;</strong> <?= Html::a('Factor Energia',
                'mailto:desarroladores@factorenergia.com') ?> -
            <strong><?= date("Y") ?></strong>

        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-light">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab">Seleccione Empresa</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane active" id="control-sidebar-home-tab">
                    <ul class="control-sidebar-menu">
                        <li>
                            Prueba
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                </div><!-- /.tab-pane -->
                <!-- Stats tab content -->
            </div>
        </aside><!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
    <?php $this->endBody() ?>
    </body>
    <!--</html>-->
    <?php
    $js = <<< JS
    /* To initialize BS3 tooltips and popovers set this below */
    $(document).tooltip({selector: '[data-tooltip="1"]'});
    $(document).popover({selector: '[data-popover="1"]'});
    
    /* Show truncated text in grids fields. */
    $(document).on('mouseover','.grid-view .rowsN', function() {
        $('#grid-tooltip')
        .html($(this).find('.rowsN-cut').html())
        .css({
            left: $(this).offset().left, 
            top: $(this).offset().top, 
            height: $(this).outerHeight
        })
        .addClass('shown');
        setTimeout(function(){
            
                $('#grid-tooltip').removeClass('shown');            
        },500);        
    });
JS;
    $this->registerJs($js);
    ?>
    <div id="grid-tooltip"></div>
    </html>
<?php
$this->endPage();
?>