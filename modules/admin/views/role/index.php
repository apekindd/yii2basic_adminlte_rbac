<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">


    <p>
        <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            //'type',
            'description:ntext',
            [
                'attribute'=>'Permissions',
                'value' => function($model){
                    $res = "";
                    $children = \yii\helpers\ArrayHelper::map($model->children, "name", "name");
                    foreach ($model->perms as $perm){
                        if($children[$perm->name] === $perm->name){
                            $res .= $perm->name."<br/>";
                        }
                    }
                    if($res == ''){
                        $res = " - ";
                    }
                    return $res;
                },
                'format'=>'html'
            ],
            //'rule_name',
            //'data:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
