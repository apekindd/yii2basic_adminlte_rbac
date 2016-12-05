<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AuthAssignment;
use Yii;
use app\modules\admin\models\User;
use app\models\User as CommonUser;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $cu = new CommonUser();
            $cu->setPassword($model->password_hash);
            $model->password_hash = $cu->password_hash;
            unset($cu);
            if($model->save()){
                //add roles
                $postRole = Yii::$app->request->post("Role");
                if($postRole) {
                    foreach ($postRole as $role) {
                        $new = new AuthAssignment();
                        $new->user_id = "".$model->id;
                        $new->item_name = $role;
                        $new->created_at = time();
                        $new->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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

        if ($model->load(Yii::$app->request->post())) {

            $hisRoles = AuthAssignment::find()->where(['=','user_id', $model->id])->asArray()->indexBy('item_name')->all();
            $postRole = Yii::$app->request->post("Role");
            //check for delete
            foreach ($hisRoles as $role=>$arr){
                if(!$postRole[$role]){
                    $r = AuthAssignment::find()->where(['=','user_id',$model->id])->andWhere(['=','item_name', $role])->one();
                    if($r) {
                        $r->delete();
                    }
                }
            }

            //check for add
            if($postRole){
                foreach ($postRole as $role){
                    if(!$hisRoles[$role]){
                        $new = new AuthAssignment();
                        $new->user_id = "".$model->id;
                        $new->item_name = $role;
                        $new->created_at = time();
                        $new->save();
                    }
                }
            }

            $cu = new CommonUser();
            if($model->oldAttributes['password_hash'] !== $model->password_hash){
                $cu->setPassword($model->password_hash);
                $model->password_hash = $cu->password_hash;
            }
            unset($cu);
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
