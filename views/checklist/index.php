<?php

use yii\helpers\Html;
use app\models\Category;
use app\models\CheckList;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
//
$this->title = Yii::t('app', 'Check Lists');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-list-index">

    <?php
    $noedit=0;
    $project_id=Yii::$app->request->cookies->get('default_obj');
    $user_id=Yii::$app->user->id;
    if(Yii::$app->request->get('d')!=''){
        $d=Yii::$app->request->get('d');
    }else{
        $d=date("d.m.Y");
    }
    if($d!=date("d.m.Y")){
        $noedit=1;
    }
    echo "<div style='color: red;' class='date'>".$d."</div>";
    echo "<div class='selectdate'><input type='text' value=\"".$d."\" id='datepicker'>&nbsp;&nbsp;&nbsp;<a href='#' onclick=\"var d=$('#datepicker').val(); window.location='/checklist.php?d='+d; return false;\">Показать</a></div>";
    $sel1=0;
    $sel2=0;
    $checkinput='';
    $checkinput2='';
    $rowch = CheckList::selectinfo($project_id, $d);
    $childall=Category::getCatChildall();

    foreach(Category::getCatMain() as $row){
    ?>
      <div><b style='color: rgb(113, 0, 255);font-size: 20px;'><?=$row['name'];?></b></div>
    <?php
        foreach($childall as $rowc) {
            if($rowc['parentid']==$row['id']){
                $sel1++;
                $cl = '';
                $checkinput = '';
                if (isset($rowch[$rowc['id']]['id'])) {
                    if ($rowch[$rowc['id']]['id'] > 0) {
                        if ($rowch[$rowc['id']]['status'] == 1) {
                            $cl = 'checkok';
                            $checkinput = 'checked';
                            $sel2++;
                        }
                    }
                }
                if ($noedit == 1) {
                    $checkinput2 = 'Disabled';
                }
                ?>
                <div rel='<?= $rowc['id']; ?>' class='<?= $cl; ?>' id='bl<?= $rowc['id']; ?>'
                     style='margin-top: 5px;margin-left:20px;'>
                    <input onclick='setcheck(<?= $rowc['id']; ?>);' type='checkbox' <?= $checkinput; ?> <?= $checkinput2; ?>
                           style='float: left;margin-right: 5px;'>
                    <span><?= $rowc['name']; ?></span>
                    <input type='hidden' id='t_add_cat' value='<?= $row['id']; ?>'>
                    <?php
                    //$resultprg = mysql_query("SELECT * FROM mantis_bug_table WHERE status!=90 and idchildcat='".$rowc['id']."'  and project_id='".$t_project_id ."' and category_id='".$rowc3[id]."' ORDER BY  id DESC ");
                    //while ($myrow = mysql_fetch_array($resultprg)) {
                    //    echo "<div class='nevpr'>".$myrow['summary']."&nbsp;<a href='/view.php?id=".$myrow['id']."'>перейти</a></div>";
                    //}

                    if (isset($rowch[$rowc['id']]['coment'])) {
                        if ($rowch[$rowc['id']]['coment'] != '') {

                            echo "<input type='hidden' id='t_add' value='1'><div style='clear:both;'></div>

                            Тип Заявки:
                            <select name=\"severity\" class=\"severity-" . $rowc['id'] . "\">
                            <option value=\"10\">Авария</option>
                            <option value=\"20\">Срочные</option>
                            <option value=\"30\">Плановые</option>
                            </select>
                            <br><br>

                            <textarea class='textar t-" . $rowc['id'] . "'>" . $rowch[$rowc['id']]['coment'] . "</textarea>";
                            if ($noedit != 1) {
                                if ($rowch[$rowc['id']]['coment'] == '')
                                    echo "<div class='savecom savecom" . $rowc['id'] . "' onclick='savecom(" . $rowc['id'] . ", '" . $rowc3['id'] . "');'>Отправить заявку</div>";
                            }
                        }
                    }
                    ?>
                </div>
            <?php
            }
        }
    }



    ?>
</div>
<script>

    function setcheck(id){
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['checklist/updateval']);?>?id_user=<?php echo $user_id;?>&id_project=<?php echo $project_id;?>&date=<?php echo date("d.m.Y");?>&id='+id,
            dataType: 'html',
            success: function(h) {
                alert(h);

                if( $("#bl"+id).find('input:checkbox').is(":checked")){
                    $( "#bl"+id ).addClass( "checkok" );
                }else{
                    $( "#bl"+id ).removeClass( "checkok" )
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

</script>