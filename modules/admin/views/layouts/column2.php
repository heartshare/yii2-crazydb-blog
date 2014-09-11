<?php
/* @var View  $this */
/* @var string $content */
use \yii\web\View;
use app\widgets\Alert;
use app\widgets\SideNav;

?>
<?php $this->beginContent('@app/modules/admin/views/layouts/main.php'); ?>
<style>
    .affix-aside{
        min-width:280px;
    }

</style>
<div class="col-md-2">
    <div data-spy="affix"  data-offset-top="60" data-offset-bottom="200" class="affix-aside">
	<?php
	$nav = [
        [
            'label' => Yii::t('app', 'Admin Home'),
            'icon' => 'home',
            'url' => ['default/index'],
        ],
        [
            'label' => Yii::t('app', 'Settings'),
            'icon' => 'cog',
            'items' =>
            [
                ['label' => Yii::t('app', 'Base Setting'), 'url' => ['config/setting'], 'icon' => 'globe'],
                ['label' => Yii::t('app', 'SEO'), 'url' => ['config/seo'], 'icon' => 'pencil'],
                ['label' => Yii::t('app', 'Slider'), 'url' => ['config/slider'], 'icon' => 'picture'],
                ['label' => Yii::t('app', 'Site Cache'), 'url' => ['config/cache'], 'icon' => 'refresh  '],
            ],
        ],
        ['label' => Yii::t('app', 'Articles'), 'icon' => 'list-alt', 'url' => ['post/index']],
        ['label' => Yii::t('app', 'Comments'), 'icon' => 'comment', 'url' => ['comment/index']],
        [
            'label' => Yii::t('app', 'Category'),
            'icon' => 'leaf',
            'items' =>
                [
                    ['label' => Yii::t('app', 'Categories'), 'url' => ['category/index'], 'icon' => 'leaf'],

                    ['label' => Yii::t('app', 'Categories Tree'), 'url' => ['category/tree'], 'icon' => 'tree-conifer'],
                ],
        ],
        [
            'label' => Yii::t('app', 'Nav'),
            'icon' => 'minus',
            'items' =>
                [
                    ['label' => Yii::t('app', 'Nav'), 'url' => ['nav/index'], 'icon' => 'minus'],

                    ['label' => Yii::t('app', 'Nav Tree'), 'url' => ['nav/tree'], 'icon' => 'tree-conifer'],
                ],
        ],
        ['label' => Yii::t('app', 'Page'), 'icon' => 'file', 'url' => ['page/index']],
        ['label' => Yii::t('app', 'Users'), 'icon' => 'user', 'url' => ['user/index']],
        ['label' => Yii::t('app', 'Links'), 'icon' => 'link', 'url' => ['link/index']],
        ['label' => Yii::t('app', 'Sources'), 'icon' => 'share-alt', 'url' => ['source/index']],
        ['label' => Yii::t('app', 'Writers'), 'icon' => 'pencil', 'url' => ['writer/index']],
        ['label' => Yii::t('app', 'Tags'), 'icon' => 'tag', 'url' => ['tag/index']],
        ['label' => Yii::t('app', 'Lookup'), 'icon' => 'asterisk', 'url' => ['lookup/index']],
    ];
	echo SideNav::widget([
        'id' => 'navigation',
        'items' => $nav,
        'view' => $this
    ]);
	?>
    </div>
</div>
<div class="col-md-10">
	<?= \yii\widgets\Breadcrumbs::widget([
		'homeLink' => ['label' => 'Home', 'url' => ['/admin/default/index']],
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
	<?= Alert::widget() ?>
	<?= $content ?>
</div>
<?php $this->endContent(); ?>