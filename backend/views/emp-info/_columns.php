<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    //     [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'emp_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'emp_branch_id',
    //     'value' => 'empBranch.branch_name',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'emp_reg_no',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'emp_name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'emp_father_name',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_cnic',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_contact_no',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_perm_address',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_temp_address',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_marital_status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_fb_ID',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'emp_gender',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_photo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_dept_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_salary_type',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_email',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_qualification',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_passing_year',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_institute_name',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'degree_scan_copy',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_date_of_birth',
    // ],// [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_religion',
    // ],// [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_domicile',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_cv',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'emp_status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_by',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'delete_status',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   