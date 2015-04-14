<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Обьекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$project_id=Yii::$app->request->cookies->get('default_obj');
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
                <b>Пользователи</b>
            </td>
            <td>
                <b>Пользователи назначенные обьекту</b>
            </td>
        </tr>
        <tr>
            <td class="tableinertd">
                <table class="table table-striped table-bordered detail-view tableiner">

                        <tr>
                            <td>
                                <a href="#"  onclick="setalluser();return false;">Добавить всех</a>
                            </td>

                        </tr>

                </table>
            </td>
            <td class="tableinertd">
                <table class="table table-striped table-bordered detail-view tableiner">

                    <tr>
                        <td>
                            &nbsp;
                        </td>

                    </tr>

                </table>
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
                            <a href="#" class="plus" onclick="setuser(<?php echo $user['id']; ?>);return false;">Добавить</a>
                        </td>
                    </tr>

                <?php

                }

                ?>
                </table>
            </td>
            <td class="resultusers tableinertd">

            </td>
        </tr>

    </table>


    <h1>CheckLists назначенный обьекту</h1>
    <table class="table table-striped table-bordered detail-view">
        <tr>
            <td class="col1">
                <b>Категории</b>
            </td>
            <td class="col2">
                <b>Категории назначенные обьекту</b>
            </td>
        </tr>
        <tr>
            <td class="tableinertd">
                <table class="table table-striped table-bordered detail-view tableiner">

                    <tr>
                        <td>
                            <a href="#"  onclick="setallob();return false;">Добавить всех</a>
                        </td>

                    </tr>

                </table>
            </td>
            <td class="tableinertd">
                <table class="table table-striped table-bordered detail-view tableiner">
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="tableinertd"  class="col1">
                <table class="table table-striped table-bordered detail-view tableiner">
                    <?php
                    $child=$categorys;
                    foreach($categorys as $category) {
                        if ($category['parentid'] == 0) {

                        ?>
                        <tr class="blue">
                            <td>
                                <?php echo $category['id']; ?>
                            </td>
                            <td>
                                <?php echo $category['name']; ?>
                            </td>
                            <td>
                                <a href="#" class="plus" onclick="setob(<?php echo $category['id']; ?>);return false;">Добавить</a>
                            </td>
                        </tr>

                        <?php
                            foreach($child as $categorych) {
                                if ($categorych['parentid'] == $category['id']) {

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $categorych['id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $categorych['name']; ?>
                                        </td>
                                        <td>
                                            <a href="#" class="plus" onclick="setob(<?php echo $categorych['id']; ?>);return false;">Добавить</a>
                                        </td>
                                    </tr>

                                <?php
                                }
                            }
                        }
                    }

                    ?>
                </table>
            </td>
            <td class="resultob tableinertd">

            </td>
        </tr>

    </table>
</div>

<script>
    $("document").ready(function(){  loadusers(); });
    function setuser(id){
        $(".resultusers").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/addobjectusers']);?>?id_project=<?php echo $project_id;?>&id='+id,
            dataType: 'html',
            success: function(html) {
                loadusers();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function setalluser(){
        $(".resultusers").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/addallobjectusers']);?>?id_project=<?php echo $project_id;?>',
            dataType: 'html',
            success: function(html) {
                loadusers();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function loadusers() {
        $(".resultusers").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/listobjectusers']);?>?id_project=<?php echo $project_id;?>',
            dataType: 'html',
            success: function(html) {
                $(".resultusers").html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function deleteuser(id) {
        $(".resultusers").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/deleteobjectusers']);?>?id_project=<?php echo $project_id;?>&id='+id,
            dataType: 'html',
            success: function(html) {
                loadusers();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }


    $("document").ready(function(){  loadob(); });
    function setob(id){
        $(".resultob").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/addobjectob']);?>?id_project=<?php echo $project_id;?>&id='+id,
            dataType: 'html',
            success: function(html) {
                loadob();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function setallob(){
        $(".resultob").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/addallobjectob']);?>?id_project=<?php echo $project_id;?>',
            dataType: 'html',
            success: function(html) {
                loadob();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function loadob() {
        $(".resultob").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/listobjectob']);?>?id_project=<?php echo $project_id;?>',
            dataType: 'html',
            success: function(html) {
                $(".resultob").html(html);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function deleteob(id) {
        $(".resultob").html('<img src="../image/loader.gif" style="width:50px;">');
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['objects/deleteobjectobs']);?>?id_project=<?php echo $project_id;?>&id='+id,
            dataType: 'html',
            success: function(html) {
                loadob();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
</script>
