<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'id_category',
            'id_type',
            // 'date_vipolneniya',
             'date_create',
            // 'date_update',
             'status',
            // 'id_coment',
            // 'user_create',
            // 'user_performer',
            // 'user_dispetcher',
            // 'id_object',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update}'],
        ],
    ]); ?>

</div>
