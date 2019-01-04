<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="login-box">
    <div class="login-box-body">
        <div class="login-logo">
            <!--            <div class="nombreEmpresaLogin">-->
            <a href=""><span class="logo-txt">Calendario</span></a>
        </div>
        <!--            </div>-->
        <hr>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'options' => ['class' => 'form-group has-feedback'],
//            'template' => "<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'template' => "{input}",
            ],
        ]); ?>

        <?= $form->field($model, 'username', [
            'inputTemplate' => '{input}' . Icon::show('user', ['class' => 'form-control-feedback'], null, true, 'span')
        ])->textInput([
            'type' => 'text',
            'autofocus' => true,
            'placeholder' => 'Nombre de usuario',

        ]) ?>

        <?= $form->field($model, 'password', [
            'inputTemplate' => '{input}' . Icon::show('lock', ['class' => 'form-control-feedback'], null, true, 'span')
        ])->passwordInput(['placeholder' => 'Contraseña']) ?>


        <div class="form-group text-center">
            <?= Html::submitButton('Acceder',
                ['class' => 'btn bg-olive btn-login btn-flat', 'name' => 'login-button']) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
