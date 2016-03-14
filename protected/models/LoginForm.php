<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'on' => 'default'],
            [['username', 'password'], 'safe'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()){
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)){
                $this->addError($attribute, 'Неправильный логин или пароль.');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }


    public function login()
    {
        if ($this->validate()) {
            //$user = $this->getUser();
            return Yii::$app->user->login($this->getUser());
        }
        else {
            return false;
        }
    }
}