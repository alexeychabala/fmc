<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "objects".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 */
class Objects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name'], 'required'],
            [['id', 'status'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Описание',
        ];
    }

    public function getListAll($id_user)
    {
        //$team = Objects::find()->orderBy('name')->all();
        $model = YII::$app->db->createCommand("SELECT * FROM objects a, userobjects b where a.id=b.id_object and b.id_user='".$id_user."' order by name");
        $list = $model->queryAll();
        return ArrayHelper::map($list, 'id', 'name');
    }

    public function getObjectInfo($id)
    {
        $ob = Objects::find()->where(['id' => $id])->one();
        return $ob->description;
    }

    public function getAllUser()
    {
        $model = YII::$app->db->createCommand("SELECT * FROM user where 1 order by username");
        $users = $model->queryAll();
        return $users;
    }

    public function getObjectCurUser($id)
    {
        $model = YII::$app->db->createCommand("SELECT * FROM userobjects where id_user='".$id."' limit 1");
        $users = $model->queryOne();
        return $users['id_object'];
    }

    public function getObjectUser($id)
    {
        $model = YII::$app->db->createCommand("SELECT a.* FROM user a, userobjects b where a.id=b.id_user and b.id_object='".$id."' order by username");
        $users = $model->queryAll();
        return $users;
    }

    public function addObjectUser($id_project, $id)
    {
        $model = YII::$app->db->createCommand("SELECT * FROM userobjects where id_object='".$id_project."' and id_user='".$id."'");
        $users = $model->queryAll();
        if(!$users){
            Yii::$app->db->createCommand()->insert('userobjects', [
                'id_object' => $id_project,
                'id_user' => $id,
            ])
                ->execute();
        }
    }

    public function addAllObjectUser($id_project)
    {
        $model = YII::$app->db->createCommand("SELECT * FROM user where 1 order by username");
        $usersall = $model->queryAll();
        foreach ( $usersall as $u) {

            $model = YII::$app->db->createCommand("SELECT * FROM userobjects where id_object='" . $id_project . "' and id_user='" . $u['id'] . "'");
            $users = $model->queryAll();
            if (!$users) {
                Yii::$app->db->createCommand()->insert('userobjects', [
                    'id_object' => $id_project,
                    'id_user' => $u['id'],
                ])
                    ->execute();
            }

        }
    }

    public function deleteObjectUser($id_project, $id)
    {

            Yii::$app->db->createCommand()->delete('userobjects', [
                'id_object' => $id_project,
                'id_user' => $id,
            ])
                ->execute();

    }

    public function getObjectOb($id)
    {
        $model = YII::$app->db->createCommand("SELECT a.* FROM category a, categoryobjects b where a.id=b.id_category and b.id_object='".$id."' order by a.parentid ASC, a.name");
        $users = $model->queryAll();
        return $users;
    }

    public function addObjectOb($id_project, $id)
    {
        $model = YII::$app->db->createCommand("SELECT * FROM category where id='".$id."'");
        $r = $model->queryOne();
        //echo $r['parentid'];
        if($r['parentid']>0){

            $model = YII::$app->db->createCommand("SELECT * FROM categoryobjects where id_object='".$id_project."' and id_category='".$r['parentid']."'");
            $obs = $model->queryAll();
            if(!$obs){
                Yii::$app->db->createCommand()->insert('categoryobjects', [
                    'id_object' => $id_project,
                    'id_category' => $r['parentid'],
                ])
                    ->execute();
            }

            $model = YII::$app->db->createCommand("SELECT * FROM categoryobjects where id_object='".$id_project."' and id_category='".$id."'");
            $obs = $model->queryAll();
            if(!$obs){
                Yii::$app->db->createCommand()->insert('categoryobjects', [
                    'id_object' => $id_project,
                    'id_category' => $id,
                ])
                    ->execute();
            }
        }else{
            $model = YII::$app->db->createCommand("SELECT * FROM categoryobjects where id_object='".$id_project."' and id_category='".$id."'");
            $obs = $model->queryAll();
            if(!$obs){
                Yii::$app->db->createCommand()->insert('categoryobjects', [
                    'id_object' => $id_project,
                    'id_category' => $id,
                ])
                    ->execute();
            }
            $model = YII::$app->db->createCommand("SELECT * FROM category where  parentid='".$id."'");
            $obsparent = $model->queryAll();
            if($obsparent){
                foreach($obsparent as $child) {
                    $model = YII::$app->db->createCommand("SELECT * FROM categoryobjects where id_object='" . $id_project . "' and id_category='" . $child['id'] . "'");
                    $obs = $model->queryAll();
                    if (!$obs) {
                        Yii::$app->db->createCommand()->insert('categoryobjects', [
                            'id_object' => $id_project,
                            'id_category' => $child['id'],
                        ])
                            ->execute();
                    }
                }
            }
        }
    }

    public function addAllObjectOb($id_project)
    {
        $model = YII::$app->db->createCommand("SELECT * FROM category where 1 order by name");
        $usersall = $model->queryAll();
        foreach ( $usersall as $u) {

            $model = YII::$app->db->createCommand("SELECT * FROM categoryobjects where id_object='" . $id_project . "' and id_category='" . $u['id'] . "'");
            $users = $model->queryAll();
            if (!$users) {
                Yii::$app->db->createCommand()->insert('categoryobjects', [
                    'id_object' => $id_project,
                    'id_category' => $u['id'],
                ])
                    ->execute();
            }

        }
    }

    public function deleteObjectob($id_project, $id)
    {

        $model = YII::$app->db->createCommand("SELECT * FROM category where id='".$id."'");
        $r = $model->queryOne();
        //echo $r['parentid'];
        if($r['parentid']>0){
            Yii::$app->db->createCommand()->delete('categoryobjects', [
                'id_object' => $id_project,
                'id_category' => $id,
            ])
                ->execute();
        }else{
            Yii::$app->db->createCommand()->delete('categoryobjects', [
                'id_object' => $id_project,
                'id_category' => $id,
            ])
                ->execute();
            $model = YII::$app->db->createCommand("SELECT * FROM category where  parentid='".$id."'");
            $obsparent = $model->queryAll();
            if($obsparent){
                foreach($obsparent as $child) {
                    Yii::$app->db->createCommand()->delete('categoryobjects', [
                        'id_object' => $id_project,
                        'id_category' =>  $child['id'],
                    ])
                        ->execute();
                }
            }
        }



    }


    public function getCategorys()
    {
        $model = YII::$app->db->createCommand("SELECT * FROM category where 1 order by `parentid` ASC, name");
        $users = $model->queryAll();
        return $users;
    }
}
