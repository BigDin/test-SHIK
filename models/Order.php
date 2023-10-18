<?php

namespace app\models;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property float|null $sum
 * @property string $created_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sum'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sum' => 'Сумма',
            'created_at' => 'Создан',
        ];
    }

    public static function getDateList(): array
    {
        $result = [];

        $months = static::find()
            ->select("EXTRACT(YEAR FROM created_at) year, EXTRACT(MONTH FROM created_at) month, COUNT(*) as quantity")
            ->asArray()
            ->orderBy(['year' => SORT_DESC, 'month' => SORT_DESC])
            ->groupBy('year, month')
            ->all();

        foreach ($months as $month) {
            if (key_exists($month['year'], $result)) {
                $result[$month['year']]['quantity'] += $month['quantity'];
                $result[$month['year']]['months'][] = [
                    'month' => $month['month'],
                    'quantity' => $month['quantity']
                ];
            } else {
                $result[$month['year']] = [
                    'quantity' => $month['quantity'],
                    'months' => [
                        [
                            'month' => $month['month'],
                            'quantity' => $month['quantity']
                        ]
                    ]
                ];
            }
        }

        return $result;
    }
}
