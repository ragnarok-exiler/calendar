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
            'columns' => [
                'user_id',
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
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => true,

            'toolbar' => [
                [
                    'content' =>
                        Html::button(Icon::show('plus'), [
                            'class' => 'btn btn-success',
                            'title' => Yii::t('kvgrid', 'Add Book'),
                            'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");'
                        ]) . ' ' .
                        Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                            'class' => 'btn btn-outline-secondary',
                            'title' => Yii::t('kvgrid', 'Reset Grid'),
                            'data-pjax' => 0,
                        ]),
                    'options' => ['class' => 'btn-group mr-2']
                ],
                '{export}',
                '{toggleData}',
            ],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'export' => [
                'fontAwesome' => true
            ],
            'bordered' => true,
            'striped' => true,
            'condensed' => true,

            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Test',
            ],
            'persistResize' => false,
            'toggleDataOptions' => ['minCount' => 10],
            'itemLabelSingle' => 'book',
            'itemLabelPlural' => 'books'
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
