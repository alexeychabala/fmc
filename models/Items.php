<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $id_category
 * @property integer $id_type
 * @property string $date_vipolneniya
 * @property string $date_create
 * @property string $date_update
 * @property integer $status
 * @property integer $id_coment
 * @property integer $user_create
 * @property integer $user_performer
 * @property integer $user_dispetcher
 * @property integer $id_object
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['id_category', 'id_type', 'status', 'id_coment', 'user_create', 'user_performer', 'user_dispetcher', 'id_object'], 'integer'],
            [['date_vipolneniya', 'date_create', 'date_update'], 'safe'],
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
            'name' => 'Суть',
            'description' => 'Подробности',
            'id_category' => 'Категория',
            'id_type' => 'Тип Заявки',
            'date_vipolneniya' => 'Когда работа должны быть выполнена?',
            'date_create' => 'Дата создания',
            'date_update' => 'Дата обновления',
            'status' => 'Статус',
            //'id_coment' => 'Id Coment',
            'user_create' => 'Создал',
            'user_performer' => 'Назначен',
            //'user_dispetcher' => 'User Dispetcher',
            'id_object' => 'Обьект',
        ];
    }


    public function getCategoryAll()
    {
        $team = Category::find()->where(['parentid' => 0])->orderBy('name')->all();
        return ArrayHelper::map($team, 'id', 'name');
    }

    public function getCategoryName($id)
    {
        $team = Category::find()->where(['id' => $id])->asArray()->one();
        return $team;
    }
    public function getTypeName($id)
    {
        $team = Type::find()->where(['id' => $id])->asArray()->one();
        return $team;
    }
    public function getTypeAll()
    {
        $team = Type::find()->orderBy('name')->all();
        return ArrayHelper::map($team, 'id', 'name');
    }

    public function getObjName($id)
    {
        $team = Objects::find()->where(['id' => $id])->asArray()->one();
        return $team;
    }
    public function getUserName($id)
    {
        $model = YII::$app->db->createCommand("SELECT * FROM user where id=$id");
        $users = $model->queryOne();
        return $users;
    }
    public function getStatusName($id)
    {
        $team = Status::find()->where(['id' => $id])->asArray()->one();
        return $team;
    }

}
