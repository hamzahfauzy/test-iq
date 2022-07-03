<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Exam */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Set Group Items';
$this->tab_active = 'groups';
$this->menu_active = 'set group items';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-create">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>Urutan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $idx => $category): ?>
                        <tr>
                            <td><?=($idx+1)?></td>
                            <td><?=$category->name?></td>
                            <td><input type="number" name="categories[<?=$category->id?>]" class="form-control" value="<?=$category->sequenced_number($model->id)?>"></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
