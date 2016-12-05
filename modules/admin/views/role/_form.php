<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">
    <div class="col-md-6">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'created_at')->textInput() ?>

    <?php // $form->field($model, 'updated_at')->textInput() ?>

        <?php
        echo "Права:<br/>";
        $children = \yii\helpers\ArrayHelper::map($model->children, "name", "name");
        foreach ($model->perms as $perm){?>
        <input type="checkbox" <?= ($children[$perm->name] === $perm->name) ? "checked" : "" ?> name="Perm[<?= $perm->name ?>]" value="<?= $perm->name ?>" /> <b><?= $perm->name ?></b><br/>
        <?php
        }
        ?>
    <br/>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
