<?php

namespace backend\controllers;

use Yii;
use common\models\StdSections;
use common\models\StdSectionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * StdSectionsController implements the CRUD actions for StdSections model.
 */
class StdSectionsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete','bulk-delete','get-section','get-section-intake','lists'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all StdSections models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new StdSectionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single StdSections model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "<b>Student Sections: </b>".$model->section_name,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-success','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new StdSections model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new StdSections();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "<b>Create new Student Section</b>",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-success','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post())){
                $transaction = \Yii::$app->db->beginTransaction();
                    try {
                    $branch_id = Yii::$app->user->identity->branch_id;
                    $model->branch_id = $branch_id;
                    $model->created_by = Yii::$app->user->identity->id; 
                    $model->created_at = new \yii\db\Expression('NOW()');
                    $model->updated_by = '0';
                    $model->updated_at = '0';
                    $model->save();                       

                    $transaction->commit();
                    //Yii::$app->session->setFlash('warning', "You have successfully add section...!");
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "Transaction Failed, Try Again...!");
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new StdSections",
                    'content'=>'<span class="text-success">Create Student Section successfully</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-success','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "<b>Create new Student Section</b>",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-success','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->section_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing StdSections model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "<b>Update Student Section: </b>".$model->section_name,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-success','type'=>"submit"])
                ];         
            }else if($model->load($request->post())){
                $transaction = \Yii::$app->db->beginTransaction();
                    try {
                    $branch_id = Yii::$app->user->identity->branch_id;
                    $model->branch_id = $branch_id;
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->updated_at = new \yii\db\Expression('NOW()');
                    $model->created_by = $model->created_by;
                    $model->created_at = $model->created_at;
                    $model->save();                       

                    $transaction->commit();
                    Yii::$app->session->setFlash('warning', "You have successfully update section...!");
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "Transaction Failed, Try Again...!");
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "<b>Student Section: </b>".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-success','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update StdSections #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->section_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing StdSections model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing StdSections model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionLists($id){
        $countSection = StdSections::find()
            ->where(['session_id' => $id])
            ->count();

        $sections = StdSections::find()
            ->join('session')
            ->where(['session_id' => $id])
            ->all();

        if($countSection > 0){
            foreach ($sections as $section) {
                echo "<option value='".$section->section_id."'>".$section->section_name."</option>";
            }
        }else{
            echo "<option> - </option>";
        }
    } 

    public function actionGetSection($classId,$sessionId){
        // fine the zip code from the locations table
        $section = StdSections::find()->where(['class_id' =>$classId,'session_id'=>$sessionId])->all();
        echo Json::encode($section); 
    }
    public function actionGetSectionIntake($sectionId){
        // fine the zip code from the locations table
        $sectionIntake = StdSections::find()->where(['section_id' =>$sectionId])->all();
        echo Json::encode($sectionIntake); 
    }
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the StdSections model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StdSections the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StdSections::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
