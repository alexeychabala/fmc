<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Обьекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objects-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновление', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
        ],
    ]) ?>
    <h1>Пользователи назначенные обьекту</h1>
    <table class="table table-striped table-bordered detail-view">
        <tr>
            <td>
                Пользователи
            </td>
            <td>
                Пользователи назначенные обьекту
            </td>
        </tr>
        <tr>
            <td class="tableinertd">
                <table class="table table-striped table-bordered detail-view tableiner">

                        <tr>
                            <td>
                                <a href="#">Добавить всех</a>
                            </td>

                        </tr>

                </table>
            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td class="tableinertd">
                <table class="table table-striped table-bordered detail-view tableiner">
                <?php
                foreach($users as $user){
?>
                    <tr>
                        <td>
                            <?php echo $user['id']; ?>
                        </td>
                        <td>
                            <?php echo $user['username']; ?>
                        </td>
                        <td>
                            <?php echo $user['email']; ?>
                        </td>
                        <td>
                            <a href="#" class="plus">+</a>
                        </td>
                    </tr>

                <?php

                }

                ?>
                </table>
            </td>
            <td>

            </td>
        </tr>

    </table>
</div>
