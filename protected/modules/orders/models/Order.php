<?php

namespace app\modules\orders\models;

use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "order".
 *
 * @property integer $id_order
 * @property string $familiya
 * @property string $name
 * @property string $otchestvo
 * @property integer $street_id
 * @property string $home
 * @property string $apartment
 * @property string $fone
 * @property string $created_at
 * @property string $updated_at
 * @property integer $user
 * @property integer $user_updated
 * @property boolean $status
 *
 * @property Street $street
 */
class Order extends \yii\db\ActiveRecord
{
    public $countorders;
    public $usercreated;
    public $userupdated;
    public $streets;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    public function behaviors()
    {
        return [
                TimestampBehavior::className(),
            [
                'class' => TimestampBehavior::className(),
                'value' => function () {
                    return date('Y-m-d H:i:s');
                }
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'user',
                'updatedAtAttribute' => 'user_updated',
                'value' => function () {
                    return Yii::$app->user->identity->getId();
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['familiya', 'street_id', 'home', 'fone',], 'required'],
            [['street_id', 'user', 'user_updated'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'boolean'],
            [['familiya'], 'string', 'max' => 64],
            [['name', 'otchestvo'], 'string', 'max' => 24],
            [['home', 'apartment'], 'string', 'max' => 8],
            [['fone'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_order' => 'Id Order',
            'familiya' => 'Фамилия',
            'name' => 'Имя',
            'otchestvo' => 'Отчество',
            'street_id' => 'Street ID',
            'home' => 'Дом',
            'apartment' => 'Квартира',
            'fone' => 'Телефон',
            'created_at' => 'Заявка принята',
            'updated_at' => 'Заявка исправлена',
            'user' => 'Создал',
            'user_updated' => 'Внёс изменения',
            'status' => 'Статус заявки ("Да" - не закрыта, "Нет" - заявка закрыта)',
            'countorders' => 'Кол-во заявок',
            'street' => 'Улица',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStreet()
    {
        return $this->hasOne(Street::className(), ['id_street' => 'street_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsername()
    {
        return $this->hasOne(User::className(), ['id_user' => 'user']);
    }

    public function getUserclosed()
    {
        return $this->hasOne(User::className(), ['id_user' => 'user_updated']);
    }

}
