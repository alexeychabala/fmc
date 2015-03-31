<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обьекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objects-index">
<?php echo "-". Yii::$app->request->cookies['default_obj'];?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать обьект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
