<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id_user
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property boolean $status
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;
    public $roles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'roles'], 'safe'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['username', 'password'], 'filter', 'filter' => 'trim'],
            [['username'], 'string', 'min' => 3, 'max' => 255],
            [['password'], 'string', 'min' => 6, 'max' => 255],
            [['username'], 'unique', 'message' => 'Это имя занято'],
            [['status'], 'boolean'],
            [['auth_key'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'username' => 'Пользователь',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'status' => 'Статус',
            'roles' => 'Роли',
        ];
    }

    /**
     * @inheritdoc
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id_user);
        return array_shift($roles);
    }

    /* Поиск */

    public static function findByUsername($username)
    {
        return static::findOne([
            'username' => $username
        ]);
    }

    public static function findById($id)
    {
        return static::findOne([
            'id_user' => $id
        ]);
    }

    /* Хелперы */

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /* Аутентификация пользователей */

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id_user;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}
