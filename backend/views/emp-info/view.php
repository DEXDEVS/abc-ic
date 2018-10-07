<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpInfo */
?>
<div class="emp-info-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'emp_id',
            'emp_name',
            'emp_father_name',
            'emp_cnic',
            'emp_contact_no',
            'emp_address',
            'emp_marital_status',
            'emp_gender',
            'emp_email:email',
            'emp_qualification',
            'emp_passing_year',
            'emp_institute_name',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>