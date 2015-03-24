<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Category $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <p>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
            <div class="box-body category-view">
                <?php
                $cate_info = $model->parent?
                    ['attribute'=>'上级分类','value'=>$model->parentCategory?$model->parentCategory->name:'无(待修复)']
                    :['attribute'=>'分类类型','value'=>'顶级分类'];
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'name',
                        'alias',
                        'displayType',
                        'desc',
                        $cate_info,
                        'display',
                        'sort_order',
                        'seo_title',
                        'seo_keywords',
                        'seo_description',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
