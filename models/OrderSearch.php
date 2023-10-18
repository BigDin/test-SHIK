<?php


namespace app\models;

use yii\base\Model;

class OrderSearch extends Order
{
    public $year;
    public $month;

    public function rules()
    {
        return [
            [['year', 'month'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
        $query = Order::find()->select('id, sum, created_at');

        if (!($this->load($params) && $this->validate())) {
            return $query;
        }

        $query->andFilterWhere(['EXTRACT(YEAR FROM created_at)' => $this->year]);
        if (isset($this->month)) {
            $query->andFilterWhere(['EXTRACT(MONTH FROM created_at)' => $this->month]);
        }

        return $query;
    }
}