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
        $project_id=Yii::$app->request->cookies->get('default_obj');
        $model = YII::$app->db->createCommand("SELECT a.* FROM category a, categoryobjects b where a.parentid= 0 and a.id=b.id_category and b.id_object='".$project_id."' order by name");
        $list = $model->queryAll();
        //$cat = Category::find()->where(['parentid' => 0])->orderBy('name')->asArray()->all();
        return $list;
    }

    public function getCatChild($id)
    {
        $project_id=Yii::$app->request->cookies->get('default_obj');
        $model = YII::$app->db->createCommand("SELECT a.* FROM category a, categoryobjects b where a.parentid= '".$id."' and a.id=b.id_category and b.id_object='".$project_id."' order by name");
        //$cat = Category::find()->where(['parentid' => $id])->orderBy('name')->asArray()->all();
        $list = $model->queryAll();
        return $list;
    }
    public function getCatChildall()
    {
        $project_id=Yii::$app->request->cookies->get('default_obj');
        $model = YII::$app->db->createCommand("SELECT a.* FROM category a, categoryobjects b where a.parentid>0 and a.id=b.id_category and b.id_object='".$project_id."' order by a.parentid, a.name");
        //$cat = Category::find()->where(['parentid' => $id])->orderBy('name')->asArray()->all();

        $list = $model->queryAll();
        return $list;
        //$cat = Category::find()->where("parentid>0")->orderBy('parentid, name')->asArray()->all();
        //return $cat;
    }
}
