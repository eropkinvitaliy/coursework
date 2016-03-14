<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id_user
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property boolean $status
 */
class RegForm extends \yii\db\ActiveRecord
{

    public $username;
    public $password;
    public $authitem;

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
            [['username', 'password', 'authitem'], 'required'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i'],
            [['username', 'password'], 'filter', 'filter' => 'trim'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['username', 'unique', 'targetClass' => User::className(),
                'message' => 'Это имя занято'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            [['username', 'password', 'authitem'], 'safe'],
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
            'authitem' => 'Группа',
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

    public function reg()
    {
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = 1;
        $respons = $user->save();
        if (false !== $respons) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->authitem);
            $auth->assign($role, $user->getId());
        }
        return $respons ? $user : null;
    }

}
