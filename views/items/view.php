<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Items;
/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Список заявок'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <!--<?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',

            [
                'attribute' => 'id_category',
                'value' => Items::getCategoryName( $model->id_category)['name'],
            ],
            [
                'attribute' => 'id_type',
                'value' => Items::getTypeName( $model->id_type)['name'],
            ],
            [
                'attribute' => 'date_vipolneniya',
                'value' => date("d-m-Y", $model->date_vipolneniya),

            ],
            [
                'attribute' => 'date_create',
                'value' => date("d-m-Y H:i:s", $model->date_create),
            ],
            [
                'attribute' => 'date_update',
                'value' => date("d-m-Y H:i:s", $model->date_update),
            ],
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => Items::getStatusName( $model->status)['name'],
            ],
            [
                'attribute' => 'id_object',
                'value' => Items::getObjName( $model->id_object)['name'],
            ],
            [
                'attribute' => 'user_create',
                'value' => Items::getUserName( $model->user_create)['username'],
            ],
            [
                'attribute' => 'user_performer',
                'value' => Items::getUserName( $model->user_performer)['username'],
            ],

        ],
    ]) ?>

</div>
