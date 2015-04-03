<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Items;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Список заявок');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Создать заявку'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="listitems">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'  => "{items}\n{pager}",
        'columns' => [

           [
               'attribute' => 'id',
               'label' => 'Код',
               'format' => 'html',
               'value' => 'id',
               'contentOptions'=>['style'=>'max-width: 50px;']
            ],
            'name',
            [
                'attribute' => 'id_category',
                'value' => function ($model) { return Items::getCategoryName( $model->id_category)['name']; },
            ],
            [
                'attribute' => 'id_type',
                'value' => function ($model) { return Items::getTypeName( $model->id_type)['name']; },
            ],
            [
                'attribute' => 'date_vipolneniya',
                'value' => function ($model) { return $model->date_vipolneniya>0 ? date("d-m-Y", $model->date_vipolneniya):''; },
                'label' => 'Дата выполнения',
            ],
            [
                'attribute' => 'date_create',
                'value' => function ($model) { return date("d-m-Y H:i:s", $model->date_create); },
            ],

            [
                'attribute' => 'status',
                'value' => function ($model) { return Items::getStatusName( $model->status)['name']; },
            ],


            [
                'attribute' => 'user_performer',
                'value' => function ($model) { return Items::getUserName( $model->user_performer)['username']; },
            ],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update}'],
        ],
    ]); ?>
    </div>
</div>
