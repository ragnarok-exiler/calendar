<?php

use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;

$this->title = 'Propio';
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
    <p> Página de visionado de calendario de propio. </p>
</div>
