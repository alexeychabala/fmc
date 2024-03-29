<?php
use yii\helpers\Html;
use app\models\Category;
use app\models\CheckList;
use \bootui\datetimepicker\Datepicker;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
//
isset(Yii::$app->user->identity->id_access_level)?$id_access_level=Yii::$app->user->identity->id_access_level:$id_access_level='';
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

    if($d!=date("d.m.Y") or $id_access_level!=90){
        $noedit=1;
    }
    //echo $noedit;
    ?>
    <div class='date'><?=$d;?></div>
    <div class='selectdate'>
        <?php
        echo Datepicker::widget([
            'name' => 'datepicker',
            'id' => 'datepicker',
            'value' => $d,
            'attribute' => 'date',
            'format' => 'DD.MM.YYYY',

        ]);
        ?>
        <a href='#' onclick="var d=$('#datepicker').val(); window.location='<?=Yii::$app->urlManager->createUrl(['checklist/index']);?>?d='+d; return false;">Показать</a>
    </div>
    <?php
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
                   // listnotready

                    if(isset($listnotready)){
                        foreach($listnotready as $val) {
                            if($val['id_category_child']==$rowc['id']) {
                                echo "<div class='nevpr'>".$val['name']."&nbsp;<a href='".Yii::$app->urlManager->createUrl(['items/update'])."?id=".$val['id']."'>перейти</a></div>";
                            }
                        }
                    }


                    ?>
                </div>
            <?php
            }
        }
    }

    if($noedit!=1){
    echo "<div class='send btn btn-success' onclick='check();'>Отправить</div>";
    }
    echo "<div><b style='font-size: 18px;color: red;'>".number_format(($sel2*100/$sel1), 2)."%</b></div>";
    ?>
</div>
<script>

    function setcheck(id){
        $.ajax({
            url: '<?=Yii::$app->urlManager->createUrl(['checklist/updateval']);?>?id_user=<?php echo $user_id;?>&id_project=<?php echo $project_id;?>&date=<?php echo date("d.m.Y");?>&id='+id,
            dataType: 'html',
            success: function(h) {
                //alert(h);

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
    function check(){
        $(".check-list-index  :input[type=checkbox]").each(function(){
            if( $(this).is(":checked")){
                //alert('ok');
            } else{
                var i=$(this).parent().attr('rel');
                var i2=$(this).parent().find('#t_add').val();
                var i3=$(this).parent().find('#t_add_cat').val();
                if(i2!=1){
                    $( "<div class='sendform'>Тип Заявки:" +
                    "<select name='severity' class='severity-"+i+"'>" +
                    "<option value='1'>Авария</option>" +
                    "<option value='2'>Срочные</option>" +
                    "<option value='3'>Плановые</option>" +
                    "</select><br>" +
                    "<textarea class='textar t-"+i+"'></textarea><div class='savecom  btn btn-success' onclick='savecom("+i+", "+i3+");'>Отправить заявку</div></div>" ).insertAfter($(this).parent().find('span'));
                }
            }

        });
    }
    function savecom(id, idcat){
        var coment=$(".t-"+id).val();
        var severity=$(".severity-"+id+" option:selected").val();

        $.post( '<?=Yii::$app->urlManager->createUrl(['checklist/updatevalitem']);?>?id_user=<?php echo $user_id;?>&id_project=<?php echo $project_id;?>&id='+id,
            { coment: coment, severity:severity, idcat:idcat })
            .done(function( h ) {
                alert('Обновлено');
                if( $("#bl"+id).find('input:checkbox').is(":checked")){
                    $( "#bl"+id+" .savecom").hide();
                    //$( "#bl"+id ).addClass( "checkok" );
                }else{
                    //$( "#bl"+id ).removeClass( "checkok" )
                    $( "#bl"+id+" .savecom").hide();
                }
            });
    }
</script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<div id="chart" style="height: 250px;"></div>
<script>
    new Morris.Line({
        element: 'chart',
        data: [
            <?php
           $dayofmonth = date('t');
           foreach($listgrafik as $val)
           {
           $d=explode('.', $val['date']);
           $v=number_format(($val['count_']*100/$itemsgrafikall), 2);
           echo "{date: '".$d[2]."-".$d[1]."-".$d[0]."', value: ".$v."},";
           }
           ?>
        ],
        xkey: 'date',
        ykeys: ['value'],
        xLabelFormat: function(date) {
            return date.getDate()+'.'+(date.getMonth())+'.'+date.getFullYear();
        },
        xLabels:'day',
        labels: ['Значение, %'],
        lineWidth: 2,
        dateFormat: function(date) {
            d = new Date(date);
            return d.getDate()+'.'+(d.getMonth())+'.'+d.getFullYear();
        }
    });
</script>