<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Objects;

/**
 * ObjectsController implements the CRUD actions for Objects model.
 */
class ObjectsController extends Controller
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
     * Lists all Objects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Objects::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Objects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'users' => Objects::getAllUser(),
            'categorys' => Objects::getCategorys(),
        ]);
    }

    public function actionListobjectusers()
    {
        $id_project=Yii::$app->request->get('id_project');
        if($id_project){
           $result="<table class=\"table table-striped table-bordered detail-view tableiner\">";
            foreach(Objects::getObjectUser($id_project) as $user){
                $result.="<tr><td>".$user['id']."</td> <td>".$user['username']."</td><td>".$user['email']."</td><td> <a href=\"#\" class\"plus\" onclick=\"deleteuser(".$user['id'].");return false;\">Удалить</a></td></tr>";
            }
            $result.="</table>";
            return  $result;
        }

    }

    public function  actionAddobjectusers()
    {
        $id_project=Yii::$app->request->get('id_project');
        $id=Yii::$app->request->get('id');
        if($id_project){
          if($id) {
              return Objects::addObjectUser($id_project, $id);
          }
        }

    }

    public function  actionAddallobjectusers()
    {
        $id_project=Yii::$app->request->get('id_project');
        //$id=Yii::$app->request->get('id');
        if($id_project){
            return Objects::addAllObjectUser($id_project);
        }

    }

    public function  actionDeleteobjectusers()
    {
        $id_project=Yii::$app->request->get('id_project');
        $id=Yii::$app->request->get('id');
        if($id_project){
            if($id) {
                return Objects::deleteObjectUser($id_project, $id);
            }
        }

    }


    public function actionListobjectob()
    {
        $id_project=Yii::$app->request->get('id_project');
        if($id_project){
            $result="<table class=\"table table-striped table-bordered detail-view tableiner\">";
                $obs=Objects::getObjectob($id_project);
                $childs=$obs;
            foreach( $obs as $ob){
                if ($ob['parentid'] == 0) {
                    $result .= "<tr class='blue'><td>" . $ob['id'] . "</td> <td>" . $ob['name'] . "</td><td> <a href=\"#\" class\"plus\" onclick=\"deleteob(" . $ob['id'] . ");return false;\">Удалить</a></td></tr>";
                }
                foreach($childs as $categorych) {
                    if ($categorych['parentid'] == $ob['id']) {
                        $result .= "<tr><td>" . $categorych['id'] . "</td> <td>" . $categorych['name'] . "</td><td> <a href=\"#\" class\"plus\" onclick=\"deleteob(" . $categorych['id'] . ");return false;\">Удалить</a></td></tr>";
                    }
                }
            }
            $result.="</table>";
            return  $result;
        }

    }

    public function  actionAddobjectob()
    {
        $id_project=Yii::$app->request->get('id_project');
        $id=Yii::$app->request->get('id');
        if($id_project){
            if($id) {
                return Objects::addObjectob($id_project, $id);
            }
        }

    }

    public function  actionAddallobjectob()
    {
        $id_project=Yii::$app->request->get('id_project');
        //$id=Yii::$app->request->get('id');
        if($id_project){
            return Objects::addAllObjectob($id_project);
        }

    }

    public function  actionDeleteobjectobs()
    {
        $id_project=Yii::$app->request->get('id_project');
        $id=Yii::$app->request->get('id');
        if($id_project){
            if($id) {
                return Objects::deleteObjectob($id_project, $id);
            }
        }

    }
    /**
     * Creates a new Objects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Objects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Objects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Objects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Objects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Objects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = Objects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
