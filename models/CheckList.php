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
     * @inheritdoc
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
}
