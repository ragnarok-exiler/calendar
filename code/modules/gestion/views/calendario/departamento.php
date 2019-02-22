<?php

use kartik\widgets\Select2;
use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;


/* @var int $year */
/* @var array $allowedYears */


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

    <?php
    Yii::$app->controller->module->registerCssFile('calendario.css', [], 'calendario-css');

    $users = \app\models\User::find()->select(['id', 'username', 'name'])->orderBy('name')->all();
    $festives = \app\modules\gestion\models\Festive::find()->select('free_day')->column();
    $monthsList = \kartik\helpers\Enum::monthList();
    $holidayTypes = \app\modules\gestion\models\HolidayType::getAssocHolidayTypes();

    $defaultDayConfig['value'] = '';
    $defaultDayConfig['class'][] = 'day';

    for ($month = 1; $month <= 12; $month++) {
        $monthConfig = [];

        $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        echo Html::tag('h4', $monthsList[$month], ['id' => strtolower($monthsList[$month])]);
        echo Html::beginTag('table', ['class' => 'month', 'id' => strtolower($monthsList[$month]) . '_table']);
        echo Html::beginTag('thead');
        echo Html::beginTag('tr');
        echo Html::tag('th', '', ['class' => 'user-header']);
        for ($day = 1; $day <= $monthDays; $day++) {
            echo Html::tag('th', $day, ['class' => 'month-header']);
        }
        echo Html::endTag('tr');
        echo Html::endTag('thead');
        foreach ($users as $user) {
            $allUserHolidays = \app\modules\gestion\models\Holidays::findAll(['user_id' => $user->id]);
            echo Html::beginTag('tr');
            echo Html::tag('td', $user->name, ['class' => 'user']);
            for ($day = 1; $day <= $monthDays; $day++) {
                $dayConfig = $defaultDayConfig;
                $dayInfo = new DateTime($year . '-' . $month . '-' . $day);
                $dayFull = $dayInfo->format('Y-m-d');

                if ($dayInfo->format('N') >= 6) {
                    $dayConfig['class'][] = 'weekend';
                } elseif (in_array($dayFull, $festives)) {
                    $dayConfig['class'][] = 'festive';
                } elseif (!empty($allUserHolidays)) {
                    foreach ($allUserHolidays as $userHoliday) {
                        if ($dayFull >= $userHoliday->start_date && $dayFull <= $userHoliday->end_date) {
                            $dayConfig['class'][] = $holidayTypes[$userHoliday->holiday_type]['class'];
                            $dayConfig['value'] = $holidayTypes[$userHoliday->holiday_type]['calendar_pin'];
                        }
                    }
                }
                $monthConfig[$user->username][$day] = $dayConfig;
                echo Html::tag('td',
                    $monthConfig[$user->username][$day]['value'],
                    ['class' => implode(' ', $monthConfig[$user->username][$day]['class'])]);
            }
            echo Html::endTag('tr');
        }
        echo Html::endTag('table');

    }

    ?>
</div>
