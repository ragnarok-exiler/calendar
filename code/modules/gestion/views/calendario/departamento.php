<?php

use factorenergia\adminlte\widgets\Box;
use kartik\helpers\Enum;
use kartik\widgets\Select2;
use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;


/* @var int $year */


$this->title = 'Departamento';
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
$initialYear = 2018;
$nextYear = date('Y') + 1;
$allowedYears = Enum::yearList($initialYear, $nextYear, true, false);




?>

<div class="calendario-default-index">

    <div class="ribbon_wrap">
        <div class="ribbon">
            <div class="bg-primary">
                <?= Html::encode($this->title) ?>
            </div>
        </div>
        <div class="ribbon_addon">
            <?php
            echo Html::beginForm(['/gestion/calendario/departamento']);
            echo Select2::widget([
                'name' => 'year',
                'data' => $allowedYears,
                'size' => Select2::SMALL,
                'theme' => Select2::THEME_BOOTSTRAP,
                'hideSearch' => true,
                'value' => $year,
                'options' => [
                    'style' => 'display:inline-block;'
                ],
                'pluginOptions' => [
                    'width' => '140px'
                ],
                'pluginEvents' => [
                    "change" => "function() { $(this).parents('form').submit(); }",
                ]
            ]);
            echo Html::endForm();
            ?>
        </div>
    </div>



    <style>
        .month {

        }

        .day {
            display: inline-block;
            border: 1px solid #DDDDDD;
            height: 35px;
            width: 35px;
            line-height: 35px;
            text-align: center;
            color: #555555;
        }

        .weekend {
            background-color: #FEFFCC;
        }

        .month-header {
            display: inline-block;
            border: 1px solid #DDDDDD;
            height: 35px;
            width: 35px;
            line-height: 35px;
            text-align: center;
            color: #555555;
            background-color: #E6E6E6;
        }

        .user-header {
            background-color: #DCE8F6;
        }

        .user {
            padding: 0 10px;
            color: #555555;
            background-color: #E6E6E6;
        }

        .holiday {
            background-color: #B4FFA8;
        }

        .festive {
            background-color: #F6BDBC;
        }


    </style>
    <?php
    $users = \app\models\User::find()->all();
    $festives = \app\modules\gestion\models\Festive::find()->select('free_day')->column();
    $monthsList = \kartik\helpers\Enum::monthList();
    for ($month = 1; $month <= 12; $month++) {
        //    $users = ['jsalgado'];
        $monthConfig = [];

        $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//     Box::begin([
//        "header" => "Expandable",
//        "expandable" => true,
//        "filled" => true,
//    ]);
        echo Html::tag('h4', $monthsList[$month]);
        echo Html::beginTag('table', ['class' => 'month', 'id' => $month]);
        echo Html::beginTag('thead');
        echo Html::beginTag('tr');
        echo Html::tag('th', '', ['class' => 'user-header']);
        for ($day = 1; $day <= $monthDays; $day++) {
            echo Html::tag('th', $day, ['class' => 'month-header']);
        }
        echo Html::endTag('tr');
        echo Html::endTag('thead');
        foreach ($users as $user) {
            $userMonthHolidays = \app\modules\gestion\models\Holidays::findAll(['user_id' => $user->id]);
            echo Html::beginTag('tr');
            echo Html::tag('td', $user->name, ['class' => 'user']);
            for ($day = 1; $day <= $monthDays; $day++) {
                $fullDate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0',
                        STR_PAD_LEFT);
                $dayInfo = new DateTime($fullDate);
                $monthConfig[$user->username][$day]['class'][] = 'day';
                if ($dayInfo->format('N') >= 6) {
                    $monthConfig[$user->username][$day]['class'][] = 'weekend';
                } elseif (in_array($fullDate, $festives)) {
                    $monthConfig[$user->username][$day]['class'][] = 'festive';
                } elseif (!empty($userMonthHolidays)) {
                    foreach ($userMonthHolidays as $userMonthHoliday) {
                        if ($fullDate >= $userMonthHoliday->start_date && $fullDate <= $userMonthHoliday->end_date) {
                            $monthConfig[$user->username][$day]['class'][] = 'holiday';
                        }

                    }
                }


                echo Html::tag('td', '', ['class' => implode(' ', $monthConfig[$user->username][$day]['class'])]);

//        $monthConfig[$user->username][$day] = [];
//        echo Html::tag('div', $day, ['class' => 'day', 'style' => '']);
//        echo $day;
            }
            echo Html::endTag('tr');
        }
        echo Html::endTag('table');
//     Box::end();


    }

    ?>
</div>
