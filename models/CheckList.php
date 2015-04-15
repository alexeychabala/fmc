<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_project
 * @property string $date
 * @property integer $id_list
 * @property string $coment
 * @property integer $status
 */
class CheckList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc//
     */
    public static function tableName()
    {
        return 'checklist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_project', 'date', 'id_list', 'coment', 'status'], 'required'],
            [['id_user', 'id_project', 'id_list', 'status'], 'integer'],
            [['coment'], 'string'],
            [['date'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_project' => 'Id Project',
            'date' => 'Date',
            'id_list' => 'Id List',
            'coment' => 'Coment',
            'status' => 'Status',
        ];
    }

    public function selectinfo($project_id, $date)
    {
        $ob = CheckList::find()->where(['id_project'=>$project_id,  'date'=>$date])->indexBy('id_list')->asArray()->all();
        return $ob;
    }

    public function update_data($id_user, $id_project, $id_list, $date)
    {
         $ob = CheckList::find()->where(['id_list'=>$id_list, 'id_project'=>$id_project,  'date'=>$date])->asArray()->one();
        if($ob['id']>0){
            //$command = $connection->createCommand("UPDATE checklist SET id_list='".$id_list."', id_project='".$id_project."',  date='".$date."' WHERE userid=1");
            //$command->execute();
            Yii::$app->db->createCommand()->delete('checklist', 'id = '.$ob['id'])->execute();

        }else{
            Yii::$app->db->createCommand()->insert('checklist', [
            'id_user' => $id_user,
            'id_project' => $id_project,
            'date' => $date,
            'id_list' => $id_list,
            'status' => 1,
            ])
            ->execute();
        }
        return 'test'.$ob['id'];
    }
    public function update_data_item($id_user, $id_project, $id_list, $date, $coment,  $severity)
    {
            $model = YII::$app->db->createCommand("SELECT * FROM category where id='".$id_list."'");
            $r = $model->queryOne();
            Yii::$app->db->createCommand()->insert('items', [
                'name' => $coment,
                'id_category' => $r['parentid'],
                'id_category_child' => $id_list,
                'id_type' => $severity,
                'status' => 1,
                'user_create' => $id_user,
                'id_object' => $id_project,
                'date_create'=> strtotime(date("Y-m-d H:i:s")),
                'date_update'=> strtotime(date("Y-m-d H:i:s")),
            ])
                ->execute();

        return '';
    }

    public function itemsdontready()
    {
        $project_id=Yii::$app->request->cookies->get('default_obj');
        //$model = YII::$app->db->createCommand("SELECT * FROM  items where id_object='".$project_id."' and status<6 order by name");
       // $list = $model->queryAll();
        //return $list;

        $ob = Items::find()->where("id_object='".$project_id."' and status<6 and id_category_child>0")->asArray()->all();
        return $ob;
    }

    public function itemsgrafik()
    {
        $project_id=Yii::$app->request->cookies->get('default_obj');
        $model = YII::$app->db->createCommand("SELECT COUNT(  `id` ) AS count_,  `date`  FROM `checklist` WHERE `date` like '%.".date("m").'.'.date("Y")."' and id_project='".$project_id."' GROUP BY  `date` ");
        //echo "SELECT * FROM `checklist` WHERE `date` like '%.".date("m").'.'.date("Y")."' and id_project='".$project_id."'";
        //exit;
        $list = $model->queryAll();
        return $list;
    }
    public function itemsgrafikall()
    {
        $project_id=Yii::$app->request->cookies->get('default_obj');
        $model = YII::$app->db->createCommand("SELECT count(a.id) as count_ FROM category a, categoryobjects b where a.parentid>0 and a.id=b.id_category and b.id_object='".$project_id."'");
        //echo "SELECT * FROM `checklist` WHERE `date` like '%.".date("m").'.'.date("Y")."' and id_project='".$project_id."'";
        //exit;
        $list = $model->queryOne();
        return $list['count_'];
    }
}

