<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Role */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            //'type',
            'description:ntext',
            //'rule_name',
            //'data:ntext',
            [
                'attribute' => 'created_ad',
                'value' => date('d.m.Y',$model->created_at)
            ],
            [
                'attribute' => 'updated_at',
                'value' => date('d.m.Y',$model->updated_at)
            ],
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

    <?php
    echo "Права:<br/>";
    $children = \yii\helpers\ArrayHelper::map($model->children, "name", "name");
    foreach ($model->perms as $perm){
        if($children[$perm->name] === $perm->name){
            echo "<p><b>".$perm->name."</b></p>";
        }
    }
    ?>
</div>
