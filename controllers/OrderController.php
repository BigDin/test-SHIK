<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class OrderController extends Controller
{
    public function actionIndex()
    {
        $dateList = Order::getDateList();
        $searchModel = new OrderSearch();
        $query = $searchModel->search(\Yii::$app->request->get());
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index',[
            'dateList' => $dateList,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

}
