<?php

namespace app\modules\orders\controllers;

use app\models\User;
use app\modules\orders\models\Street;
use Yii;
use app\modules\orders\models\Order;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrderController extends Controller
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
        ];
    }

    /**
     * Lists all Orders models у которых статус true(1).
     * @return mixed
     */
    public function actionIndex($status = 1)
    {
        $query = Order::find()
            ->select(['home', 'street_id', 'COUNT(home) AS countorders'])
            ->where(['status' => $status])
            ->groupBy(['home', 'street_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if (1 == $status) {
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('close', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHome($street, $home, $status = 1)
    {
        $query = Order::find()
            ->select('*')
            ->where(['status' => $status, 'street_id' => $street, 'home' => $home]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);
        $model = $dataProvider->getModels()[0];
        if (1 == $status) {
            return $this->render('home', [
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
        return $this->render('closehome', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }


    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->usercreated = User::findById($model->user);
        $model->userupdated = User::findById($model->user_updated);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        $post = Yii::$app->request->post();
        if (!empty($post)) {
            if ($model->load($post) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_order]);
            }
        }
        $model->streets = Street::find()->all();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if (!empty($post)) {
            if ($model->load($post) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_order]);
            }
        }
        $model->streets = Street::find()->all();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = !empty($model->status) ? $model->status = 0 : $model->status = 1;;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
