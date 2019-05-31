<?php

namespace app\controllers\tutorial;

use Yii;
use yii\db\Expression;
use yii\web\Response;

use app\models\tutorial\People;

class PeopleController extends \yii\web\Controller
{
    // disable CSRF Token
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionGet() {
        Yii::$app->response->format = Response:: FORMAT_JSON;

        $people = People::find()->all();
        if(count($people) > 0 ) {
            return array('status' => true, 'data'=> $people);
        } else {
            return array('status' => false, 'data' => 'No Student Found');
        }
    }

    // create people
    public function actionCreate() {
        Yii::$app->response->format = Response:: FORMAT_JSON;
        $people = new People();
        $people->scenario = People:: SCENARIO_CREATE;
        $people->attributes = Yii::$app->request->post();
        if($people->validate()) {
            $people->save();
            return array('status' => true, 'data'=> 'Data people berhasil di tambahkan.');
        } else {
            return array('status' => false , 'data'=>$people->getErrors());
        }
    }

    // update people
    public function actionUpdate() {
        Yii::$app->response->format = Response:: FORMAT_JSON;
        $attributes = Yii::$app->request->post();

        $people = People::findOne(['id' => $attributes['id']]);
        if(!empty($people)) {
            $people->attributes = Yii::$app->request->post();
            $people->modifiedon = new Expression('NOW()');
            $people->save();
            return array('status' => true, 'data' => 'Data people berhasil di ubah.');
        } else {
            return array('status' => false, 'data' => 'People Tidak Ditemukan');
        }
    }

    // delete people *soft delete*
    public function actionDelete()
    {
        Yii::$app->response->format = Response:: FORMAT_JSON;
        $attributes = Yii::$app->request->post();

        $people = People::findOne(['id' => $attributes['id']]);
        if(!empty($people)) {
            $people->deletedon = new Expression('NOW()');
            $people->save();
            return array('status' => true, 'data' => 'Data people berhasil di hapus.');
        } else {
            return array('status' => false, 'data' => 'People Tidak Ditemukan');
        }
    }
}
