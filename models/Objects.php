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

    public function getListAll()
    {
        $team = Objects::find()->orderBy('name')->all();
        return ArrayHelper::map($team, 'id', 'name');
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
}
