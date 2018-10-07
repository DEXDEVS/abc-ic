<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Branches */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branches-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'branch_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_contact_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
