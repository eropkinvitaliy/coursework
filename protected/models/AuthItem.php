<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 */
class AuthItem extends \yii\db\ActiveRecord
{
    public $permissions;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['name', 'unique'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z]+$/'],
            ['name', 'filter', 'filter' => 'trim'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'type' => 'Type',
            'description' => 'Краткое описание',
            'rule_name' => 'Rule Name',
            'data' => 'Подробное описание',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'permission' => 'Разрешения',
        ];
    }

    /**
     * @return string $this->data десериализованное после поиска
     */
    public function afterFind()
    {
        return $this->data = unserialize($this->data);
    }

    /**
     * @return string $this->data сериализованное перед сохранением
     */

    public function beforeSave($insert)
      {
          if (parent::beforeSave($insert)) {
              $this->data = serialize($this->data);
              return true;
          } else {
             return false;
         }
 }

    public static function getDescriptionRoleByUser($id)
    {
        $role = Yii::$app->authManager->getRolesByUser($id);
        $role = ArrayHelper::map($role, 'name', 'description');
        return array_shift($role);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }
}
