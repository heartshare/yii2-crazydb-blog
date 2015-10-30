<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
$asset = AppAsset::register($this);
$menu_items = [
    ['label' => 'Home', 'url' => ['site/index']],
    ['label' => 'About', 'url' => ['site/about']],
    ['label' => 'Contact', 'url' => ['site/contact']],
];
if(Yii::$app->user->isGuest){
    $menu_items[] = ['label' => 'Login', 'url' => ['site/login']];
}else{
    $menu_items[] = ['label' => Yii::$app->user->identity->nickname, 'items' => [
            ['label' => 'Admin Page','url' => ['admin/']],
            ['label' => 'Logout','url' => ['site/logout']],
        ],
    ];
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <header class="index-header">
        <div class="col-md-4 index-logo">
            <?=Html::img("{$asset->baseUrl}/images/site-logo.jpg", ['class' => 'img-circle']) ?>
        </div>
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'options' => [
                    'class' => 'container',
                ],
                'innerContainerOptions'=>[
                    'class'=>'navbar navbar-default col-md-7'
                ],
            ]);
3        ?>
        <?= Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $menu_items,
            ]);
            NavBar::end();
        ?>
    </header>
    <?= $content ?>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; X-CMS <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>