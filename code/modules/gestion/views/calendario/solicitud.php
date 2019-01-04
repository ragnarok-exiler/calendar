<?php


/** @var $holidays app\modules\gestion\models\Holidays */

use kartik\detail\DetailView;
use kartik\icons\Icon;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;

$this->title = 'Solicitud';
$festives = \app\modules\gestion\models\Festive::find()->select('free_day')->column();

$blockedDates = array_map(function ($festive) {
    return date('d/m/Y', strtotime($festive));
}, $festives);

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
        echo DetailView::widget([
            'model' => $holidays,
            'mode' => DetailView::MODE_EDIT,
            'condensed' => true,
            'bordered' => true,
            'bootstrap' => true,
            'panel' => [
                'heading' => Icon::show('calendar') . Yii::t('calendario', 'Petición de días'),
                'type' => DetailView::TYPE_PRIMARY,
            ],
            'formOptions' => [
                'id' => 'solicitud-dias',
                'action' => Url::to(['/gestion/calendario/process-solicitud'])
            ],
            'buttons1' => '',
            'buttons2' => '',
            'attributes' => [
                [
                    'columns' => [
                        [
                            'attribute' => 'start_date',
                            'format' => 'date',
                            'type' => DetailView::INPUT_WIDGET,
                            'widgetOptions' => [
                                'class' => 'kartik\datecontrol\DateControl',
                                'widgetOptions' => [
                                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'todayBtn' => true,
                                        'daysOfWeekDisabled' => [0, 6],
                                        'daysOfWeekHighlighted' => [0, 6],
                                        'datesDisabled' => $blockedDates
                                    ]
                                ]
                            ]
                        ],
                        [
                            'attribute' => 'end_date',
                            'format' => 'date',
                            'type' => DetailView::INPUT_WIDGET,
                            'widgetOptions' => [
                                'class' => 'kartik\datecontrol\DateControl',
                                'widgetOptions' => [
                                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'todayBtn' => true,
                                        'daysOfWeekDisabled' => [0, 6],
                                        'daysOfWeekHighlighted' => [0, 6],
                                        'datesDisabled' => $blockedDates
                                    ]
                                ]
                            ]
                        ]

                    ]
                ]
            ]
        ]);
        echo Html::beginTag('div', ['class' => 'btn-toolbar']);
        echo Html::a('Cancelar', Url::to(['/gestion/calendario']), ['class' => 'btn btn-danger pull-right']);
        echo Html::button('Solicitar',
            ['type' => 'button', 'id' => 'confirm', 'class' => 'btn btn-success pull-right']);
        echo Html::endTag('div');

        ?>
    </div>
<?php
$this->registerJs(<<<JS
$(document).on('click','#confirm',function(){
    $('#solicitud-dias').submit();
})
JS
);
