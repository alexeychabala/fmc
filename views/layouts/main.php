<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Objects;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Shen',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse   navbar-fixed-top navbar-top',
                ],
            ]);
            if(!Yii::$app->user->isGuest ){
                echo Nav::widget([
                        'options' => ['class' => 'navbar-nav navbar-right'],
                        'items' => [

                            ['label' => 'CheckList', 'url' => ['/site/index']],
                            ['label' => 'Cписок заявок', 'url' => ['/items/index']],
                            ['label' => 'Cоздать заявку', 'url' => ['/items/create']],
                            ['label' => 'Моя учетная запись', 'url' => ['/user/profile']],
                            ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                                'url' => ['/site/logout'],
                                'linkOptions' => ['data-method' => 'post']],
                    ],
                ]);

            }else{
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => 'Вход', 'url' => ['/site/login']],
                    ],
                ]);

            }

            NavBar::end();
        ?>

        <?php
        if(Yii::$app->user->isGuest ) {
            NavBar::begin([
                'options' => [
                    'class' => 'navbar-inverse navbar-admin',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Список пользователей', 'url' => ['/user/admin']],
                    ['label' => 'Список объектов', 'url' => ['/objects/index']],
                ],
            ]);

            NavBar::end();
        }
        ?>

        <? if(!Yii::$app->user->isGuest ){?>
        <?= Html::dropDownList('obj', 0,
            Objects::getListAll(),
            ['prompt' => Yii::t('app', 'Выберите...'), 'id'=>"obj", 'class'=>"form-control sel-obj"]
        )  ?>
        <? }?>
        <? if(!Yii::$app->user->isGuest ){?>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
        <? }?>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Shen <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
