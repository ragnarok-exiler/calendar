<?php


/* @var $searchModel app\modules\gestion\models\HolidaysSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */


use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\icons\Icon;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;

$this->title = 'Peticiones';
echo Breadcrumbs::widget([
    'links' => [
        [
            'label' => 'Calendario',
            'url' => ['/gestion/calendario'],
        ],
        [
            'label' => $this->title,
            'url' => false,
            'class' => 'active'
        ]
    ]
]);
?>
    <div class="calendario-default-index">
        <div class="ribbon_wrap">
            <div class="ribbon">
                <div class="bg-primary">
                    <?= Html::encode($this->title) ?>
                </div>
            </div>
        </div>
        <?php
        echo GridView::widget([
            'id' => 'kv-grid-demo',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => Icon::show('calendar') . 'Solicitudes',
                'after' => false
            ],
            'pjax' => true,
            'bordered' => true,
            'striped' => true,
            'condensed' => true,
            'hover' => true,
            'persistResize' => false,
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'containerOptions' => ['style' => 'overflow: auto', 'class' => ''],
            'toggleDataOptions' => ['minCount' => 10],
            'toolbar' => [
                [
                    'content' =>
                        Html::a(Icon::show('plus'), ['solicitud'],[
                            'class' => 'btn btn-success',
                            'title' => Yii::t('kvgrid', 'Nueva solicitud'),
                            'data' => [
                                'tooltip' => 1,
                                'pjax' => 0
                            ],
                        ]) . ' ' .
                        Html::a(Icon::show('repeat'), ['/gestion/calendario/gestion-solicitudes'], [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('kvgrid', 'Resetear Tabla'),
                            'data-pjax' => 0,
                        ]),
                    'options' => ['class' => 'btn-group mr-2']
                ],
                '{export}',
                '{toggleData}',
            ],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'export' => ['fontAwesome' => true],
            'columns' => [
//                'user_id',
                [
                    'attribute' => 'start_date',
                    'format' => 'date',
                    'filterType' => 'kartik\datecontrol\DateControl',
                    'filterWidgetOptions' => [
                        'widgetOptions' => [
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'todayBtn' => true,
                            ],
                        ],
                        'ajaxConversion' => true,
                        'asyncRequest' => false
                    ]
                ],
                'days_number',
                'departmen_responsable_accepted',
                'boss_accepted',
            ],


        ]);
        ?>
    </div>
<?php
$this->registerJs(<<<JS
$(document).on('click','#confirm',function(){
    $('#solicitud-dias').submit();
})
JS
);
