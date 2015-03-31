<?php

use yii\helpers\Html;
use \bootui\datetimepicker\Datepicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="items-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id_category')->dropDownList(
        $model->getCategoryAll(),
        ['prompt' => Yii::t('app', 'Выберите категорию...')]
    )  ?>

    <?= $form->field($model, 'id_type')->dropDownList(
        $model->getTypeAll(),
        ['prompt' => Yii::t('app', 'Выберите Тип Заявки...')]
    )  ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_vipolneniya')->widget(Datepicker::className(), [
        'format' => 'DD-MM-YYYY'
        ]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Cоздать') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
