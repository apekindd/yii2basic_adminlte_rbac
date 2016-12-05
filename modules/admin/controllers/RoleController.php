<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AuthItemChild;
use Yii;
use app\modules\admin\models\Role;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Role::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere(['=','type',Item::TYPE_ROLE]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();

        if ($model->load(Yii::$app->request->post())) {
            $model->type = Item::TYPE_ROLE;
            if($model->save()) {
                //add connections
                $postPerm = Yii::$app->request->post("Perm");
                if($postPerm) {
                    foreach ($postPerm as $perm) {
                        $new = new AuthItemChild();
                        $new->parent = $model->name;
                        $new->child = $perm;
                        $new->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->name]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $hisPerms = ArrayHelper::map(AuthItemChild::find()->asArray()->where(['=','parent',$model->oldAttributes['name']])->all(),"child", "child");
            $postPerm = Yii::$app->request->post("Perm");
            //check for delete
            foreach ($hisPerms as $perm){
                if(!$postPerm[$perm]){
                    $conn = AuthItemChild::find()->where(['=','child',$perm])->andWhere(['=','parent', $model->oldAttributes['name']])->one();
                    if($conn) {
                        $conn->delete();
                    }
                }
            }
            //check for add
            if($postPerm){
                foreach ($postPerm as $perm){
                    if(!$hisPerms[$perm]){
                        $new = new AuthItemChild();
                        $new->parent = $model->oldAttributes['name'];
                        $new->child = $perm;
                        $new->save();
                    }
                }
            }

            $model->type = Item::TYPE_ROLE;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->name]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Role model.
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
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
