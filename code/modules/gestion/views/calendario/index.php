<?php

use kartik\icons\Icon;
use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;

/* @var $this yii\web\View */

$this->title ='Calendario';
echo Breadcrumbs::widget([
    'links' => [
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

    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>

