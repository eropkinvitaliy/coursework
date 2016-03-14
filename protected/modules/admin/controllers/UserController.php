<?php

namespace app\modules\admin\controllers;

use app\models\AuthItem;
use Yii;
use app\models\User;
use app\modules\admin\models\RegForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all active User models.
     * @return mixed
     */
    public function actionIndex($status = 1)
    {
        $query = User::find()
            ->select(['id_user', 'username'])
            ->where(['status' => (int)$status]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'status' => $status,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'role' => AuthItem::getDescriptionRoleByUser($id),
        ]);
    }

    /**
     * Creates a new User.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionReg()
    {
        $model = new RegForm();
        $model->authitem = Yii::$app->authManager->getRoles();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user = $model->reg()) {
                return $this->redirect('index');
            }
            Yii::error('Ошибка регистрации');
            return $this->refresh();
        }
        return $this->render(
            'reg', ['model' => $model]
        );
    }

    /**
     * Deletes an existing User model (делает пользователя не активным).
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        if ('superuser' !== $user->username) {
            $user->status = !empty($user->status) ? $user->status = 0 : $user->status = 1;;
            $user->save();
        }
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if (!empty($post)) {
            $model->load($post);
            if (!empty($post['User']['password'])) {
                $model->setPassword($post['User']['password']);
            }
            $model->save();
            $this->reassign($id);
            return $this->redirect(['view', 'id' => $model->id_user]);
        } else {
            $model->roles = Yii::$app->authManager->getRoles();
            $role = Yii::$app->authManager->getRolesByUser($id);
            return $this->render('update', [
                'model' => $model, 'role' => $role,
            ]);
        }
    }

    /**
     * Метод переназначает группу у пользователя
     * @param $id
     */
    protected function reassign($id)
    {
        $newrole = Yii::$app->request->post('User')['roles'];
        $auth = Yii::$app->authManager;
        $auth->revokeAll($id);
        $auth->assign($auth->getRole($newrole), $id);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
