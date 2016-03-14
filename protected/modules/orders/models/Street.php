<?php

namespace app\modules\orders\models;

use Yii;

/**
 * This is the model class for table "streets".
 *
 * @property integer $id_street
 * @property string $namestreet
 *
 * @property Order[] $order
 */
class Street extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'streets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['namestreet'], 'required'],
            [['namestreet'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_street' => 'Id Street',
            'namestreet' => 'Название улицы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['street_id' => 'id_street']);
    }
}
