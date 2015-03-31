<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * UserSearch represents the model behind the search form about User.
 */
class ItemsSearch extends Model
{
    /** @var string */
    public $id;

    /** @var string */
    public $name;



    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id'        => \Yii::t('items', 'id'),
            'name'           => \Yii::t('items', 'name'),
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Items::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id'=> $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
