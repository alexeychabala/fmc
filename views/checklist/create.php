<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CheckList */

$this->title = Yii::t('app', 'Create Check List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Check Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

