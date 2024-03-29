<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Objects;
/* @var $this //\yii\web\View */
/* @var $content string */

AppAsset::register($this);
isset(Yii::$app->user->identity->id_access_level)?$id_access_level=Yii::$app->user->identity->id_access_level:$id_access_level='';

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

                            ['label' => 'CheckList', 'url' => ['/checklist/index']],
                            ['label' => 'Cписок заявок', 'url' => ['/items/index']],
                            ['label' => 'Cоздать заявку', 'url' => ['/items/create']],
                            ['label' => 'Моя учетная запись', 'url' => ['/user/profile']],
                            ['label' => 'Выход ('.Yii::$app->user->identity->username . ')',
                                'url' => ['/user/logout'],
                                'linkOptions' => ['data-method' => 'post']],
                    ],
                ]);

            }else{
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => [
                        ['label' => 'Вход', 'url' => ['/user/login']],
                    ],
                ]);

            }

            NavBar::end();

        if($id_access_level==90) {
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

        if($id_access_level>0){
        ?>
        <div class="bl-div <?php if($id_access_level==90) {echo " admin-top";}?>">

        <?php
        if(Yii::$app->request->post('obj')>0) {
            $default_obj=Yii::$app->request->post('obj');
        }else{
            $default_obj=Yii::$app->request->cookies->get('default_obj');
        }
        echo Html::beginForm(array('site/index'), 'post', array('enctype' => 'multipart/form-data'));
        echo Html::dropDownList('obj', $default_obj,  Objects::getListAll(Yii::$app->user->id),  [ 'id'=>"obj", 'class'=>"form-control sel-obj", 'onchange'=>'this.form.submit()'] );
        echo Html::endForm();
        if($default_obj){
            echo Objects::getObjectInfo($default_obj);
        }

        ?>
        </div>
        <?php
        }
        ?>

        <div class="container">
            <?php if($id_access_level>0){
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
            }
            ?>
            <?= $content ?>
        </div>

    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Shen <?= date('Y') ?></p>
            <p class="pull-right"></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
