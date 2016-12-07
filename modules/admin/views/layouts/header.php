<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . "Test" . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <ul class="nav navbar-nav" style="float:right">
            <li class="dropdown" >
                <a><?= Yii::$app->user->identity->username ?></a>
                <?php /*echo Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
        'Logout (' . Yii::$app->user->identity->username . ')',
        ['class' => 'btn btn-link logout']
        )
        . Html::endForm()*/?>
            </li>

            <li class="hidden-xxs">
                <a href="<?= \yii\helpers\Url::to(['/site/logout']) ?>" class="btn">
                    <i class="fa fa-power-off"></i>
                </a>
            </li>
            </ul>
    </nav>
</header>
