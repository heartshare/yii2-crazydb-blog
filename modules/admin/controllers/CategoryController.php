<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Category;
use app\models\search\CategorySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\admin\components\Controller;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all Category models via tree.
     * @return mixed
     */
    public function actionTree()
    {
        return $this->render('tree');
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->parent == 0){
                $model->saveNode();
            } else if ($model->parent){
                $root = $this->findModel($model->parent);
                $model->appendTo($root);
            }
            return $this->render('tree');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent = $model->parent()->One();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveNode();
            if ($model->parent == 0 && !$model->isRoot()){
                $model->moveAsRoot();
            } elseif ($model->parent != 0 && $model->parent != $parent->id){
                $root = $this->findModel($model->parent);
                $model->moveAsLast($root);
            }
            return $this->render('tree');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * @param string $id
     * @param string $updown
     * @return mixed
     */
    public function actionMove($id,$updown)
    {
        $model=$this->findModel($id);

        if($updown=="down") {
            $sibling=$model->next()->one();
            if (isset($sibling)) {
                $model->moveAfter($sibling);
                return $this->redirect(array('tree'));
            }
            return $this->redirect(array('tree'));
        }
        if($updown=="up"){
            $sibling=$model->prev()->one();
            if (isset($sibling)) {
                $model->moveBefore($sibling);
                return $this->redirect(array('tree'));
            }
            return $this->redirect(array('tree'));
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteNode();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
