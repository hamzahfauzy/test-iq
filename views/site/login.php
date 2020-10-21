<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<center>
<img src="<?=Url::to(['images/logo.png'])?>" width="100px">
</center>
<br>
<?php $form = ActiveForm::begin(); ?>
    <!--begin::Title-->
    <div class="pb-13 pt-lg-0 pt-5">
        <h3 align="center" class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg"><?= Yii::$app->name ?> - <?= Html::encode($this->title) ?></h3>
    </div>
    <!--begin::Title-->
    <!--begin::Form group-->
    <?= 
        $form->field($model, 'username')
            ->textInput([
                'autofocus' => true,
                'class'=>'form-control form-control-solid h-auto py-6 px-6 rounded-lg',
                'placeholder'=>'Username'
            ])
            ->label('Username',['class'=>'font-size-h6 font-weight-bolder text-dark']) 
    ?>

    <?= 
        $form->field($model, 'password')
            ->passwordInput([
                'class'=>'form-control form-control-solid h-auto py-6 px-6 rounded-lg',
                'placeholder'=>'Password'
            ])
            ->label('Password',['class'=>'font-size-h6 font-weight-bolder text-dark'])
    ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-sm-12\">{input} {label}</div>\n<div class=\"col-lg-12\">{error}</div>",
    ]) ?>

    <div class="pb-lg-0 pb-5">
        <button type="submit" id="kt_login_signin_submit" class="btn btn-primary btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
    </div>
    <!--end::Form group-->
<?php ActiveForm::end(); ?>
