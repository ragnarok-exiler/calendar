<?php


/** @var $holidays app\modules\gestion\models\Holidays */

use app\models\User;
use app\modules\gestion\models\HolidayType;
use kartik\detail\DetailView;
use kartik\icons\Icon;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;

$this->title = 'Solicitud';
$festives = \app\modules\gestion\models\Festive::find()->select('free_day')->column();

$blockedDates = array_map(function ($festive) {
    return date('d/m/Y', strtotime($festive));
}, $festives);
if (Yii::$app->user->can('superAdmin')) {
    $otherUser = [
        'attribute' => 'user_id',
        'type' => DetailView::INPUT_SELECT2,
//        'value'=> Yii::$app->user->id,
        'widgetOptions' => [
            'size' => Select2::SMALL,
            'data' => ArrayHelper::map(User::find()->select([
                'id',
                new \yii\db\Expression("CONCAT(name, ' <',email,'>') AS name")
//                'name'
            ])->where(['status' => 10])->all(),
                'id', 'name'),
//            'hideSearch' => true,
            'theme' => Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Seleccionar usuario ...'],
            'pluginOptions' => [
                'dropdownAutoWidth' => true
            ]
        ]
    ];
} else {
    $otherUser = [
        'value' => '',
        'label' => ''
    ];
}

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
        echo Html::beginTag('div', ['class' => 'col-md-12 col-lg-7']);
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
                'action' => Url::to(['/gestion/calendario/process-solicitud']),
            ],
            'labelColOptions' => ['class' => 'col-xs-2'],
            'valueColOptions' => ['class' => 'col-xs-3'],
            'buttons1' => '',
            'buttons2' => '',
            'attributes' => [
                [
                    'columns' => [
                        [
                            'attribute' => 'holiday_type',
                            'type' => DetailView::INPUT_SELECT2,

                            'widgetOptions' => [
                                'value' => 1,
                                'size' => Select2::SMALL,
                                'data' => ArrayHelper::map(HolidayType::find()->where(['requestable' => 1])->all(),
                                    'id', 'name'),
                                'hideSearch' => true,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'pluginOptions' => [
                                    'dropdownAutoWidth' => true

                                ],
                                'pluginEvents' => [
                                    "change" => "function() {
                                    console.log($(this).val());
                                    console.log(($(this).val() === 1));
                                        if($(this).val() === '1'){
                                            $('#holidays-end_date').removeAttr('disabled').parents('.kv-form-attribute').show().closest('td').prev().text('Fecha Fin');
                                        }else{                                        
                                           $('#holidays-end_date-disp').kvDatepicker('clearDates').parent().siblings('input').attr('disabled','disabled').parents('.kv-form-attribute').hide().closest('td').prev().text('');
                                        }
                                     }",
                                ]
                            ]
                        ],
                        $otherUser
                    ]
                ],
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
                                    'options' => [
                                        'autocomplete' => 'off'
                                    ],
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
                                    'options' => [
                                        'autocomplete' => 'off'
                                    ],
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
                ],
                [
                    'columns' => [
                        [
                            'label' => 'Horas',
                            'attribute' => 'days_number',
                            'type' => DetailView::INPUT_SELECT2,
                            'widgetOptions' => [
                                'size' => Select2::SMALL,
                                'data' => [
                                    '0.125' => 1,
                                    '0.25' => 2,
                                    '0.375' => 3
                                ],
                                'hideSearch' => true,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => ['placeholder' => 'Seleccionar tipo ...'],
                            ],
                            'visible' => false
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
        echo Html::endTag('div');


        ?>
    </div>
<?php
$this->registerJs(<<<JS
$(document).on('click','#confirm',function(){
    $('#solicitud-dias').submit();
});
JS
);
