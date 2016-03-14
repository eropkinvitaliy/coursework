<?php

namespace app\modules\orders;

use yii\filters\AccessControl;

class module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\orders\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
