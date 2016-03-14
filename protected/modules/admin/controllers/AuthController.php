<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\AuthItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

iconv_set_encoding('input_encoding', 'UTF-8');

/**
 * AuthController implements the CRUD actions for AuthItem model.
 */
class AuthController extends Controller
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
     * Lists all Roles.
     * @return mixed
     */
    public function actionIndex()
    {
        $roles = Yii::$app->authManager->getRoles();
        return $this->render('index', ['roles' => $roles]);
    }

    /**
     * Lists all Permissions.
     * @return mixed
     */
    public function actionPermissions()
    {
        $permissions = Yii::$app->authManager->getPermissions();
        return $this->render('permissions/index', ['permissions' => $permissions]);
    }


    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($type = 1, $id)
    {
        if ($type == 2) {
            return $this->render('permissions/view', [
                'model' => $this->findModel($id),
            ]);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'permissions' => Yii::$app->authManager->getPermissionsByRole($id)
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'index' or 'permissions' page.
     * @return mixed
     */
    public function actionCreate($type = 1)
    {
        $model = new AuthItem();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($type == 2) {
                return $this->redirect('permissions');
            }
            return $this->redirect('index');
        } else {
            if ($type == 2) {
                return $this->render('permissions/create', ['model' => $model]);
            }
            $model->permissions = Yii::$app->authManager->getPermissions();
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($type = 1, $id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($type == 2) {
                return $this->redirect(['view', 'type' => 2, 'id' => $model->name]);
            }
        } else {
            if ($type == 2) {
                return $this->render('permissions/update', ['model' => $model]);
            }
            $model->permissions = Yii::$app->authManager->getPermissionsByRole($id);
            return $this->render('update', ['model' => $model]);
        }
        return $this->redirect(['view', 'id' => $model->name]);
    }

    /**
     * Deletes role an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Deletes permission an existing AuthItem model.
     * If deletion is successful, the browser will be reender to the 'update' page.
     * @param string $id
     * @return mixed
     */

    public function actionDelChildRole($id)
    {
        if ($data = Yii::$app->request->post('AuthItem')) {
            $group = Yii::$app->authManager->getRole(trim($data['name']));
            $permission = Yii::$app->authManager->getPermission($id);
            Yii::$app->authManager->removeChild($group, $permission);
        }
        $model = $this->findModel($data['name']);
        $model->permissions = Yii::$app->authManager->getPermissionsByRole($data['name']);
        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes permission an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'permissions' page.
     * @param string $id
     * @return mixed
     */

    public function actionDelPermission($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['permissions']);
    }

    public function actionAddPermissions($id)
    {
        $model = $this->findModel($id);
        $permissions = Yii::$app->request->post('permission');
        if ($permissions) {
            $group = Yii::$app->authManager->getRole($id);
            foreach ($permissions as $key => $value) {
                $permission = Yii::$app->authManager->getPermission(trim($key));
                Yii::$app->authManager->addChild($group, $permission);
            }
            return $this->redirect(['update', 'id' => $model->name]);
        }
        $selfpermissions = Yii::$app->authManager->getPermissionsByRole($id);
        $allpermissions = Yii::$app->authManager->getPermissions();
        $permissions = array_diff_key($allpermissions, $selfpermissions);
        return $this->render('addpermissions', ['model' => $model, 'permissions' => $permissions]);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Такой записи не обнаружено.');
        }
    }

}
