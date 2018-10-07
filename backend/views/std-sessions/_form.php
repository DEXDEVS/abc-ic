<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Branches;

/* @var $this yii\web\View */
/* @var $model common\models\StdSessions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="std-sessions-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'session_branch_id')->dropDownList(
                    ArrayHelper::map(Branches::find()->all(),'branch_id','branch_name'),
                    ['prompt'=>'Select Branch..']
                )?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'session_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'session_start_date')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'session_end_date')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>
            </div>
            
        </div>


        
    <!-- 

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
