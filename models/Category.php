<?php

namespace app\models;
//
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parentid
 * @property string $name
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentid', 'name'], 'required'],
            [['parentid'], 'integer'],
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
            'parentid' => 'Parentid',
            'name' => 'Name',
        ];
    }
    public function getCatMain()
    {

        $cat = Category::find()->where(['parentid' => 0])->orderBy('name')->asArray()->all();
        return $cat;
    }

    public function getCatChild($id)
    {
        $cat = Category::find()->where(['parentid' => $id])->orderBy('name')->asArray()->all();
        return $cat;
    }
    public function getCatChildall()
    {
        $cat = Category::find()->where("parentid>0")->orderBy('parentid, name')->asArray()->all();
        return $cat;
    }
}
