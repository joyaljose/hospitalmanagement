<?php

use yii\helpers\Html;
//use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\helpers\ArrayHelper;
use common\models\Investigations;
use common\models\DoctorsDetails;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="schedule-form">
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissable">
             <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
             <h4><i class="icon fa fa-check"></i>Error!</h4>
             <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="row">
        <div class="col-md-6">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group field-schedule-type has-success">
                <label class="control-label" for="type">Choose a Type:</label>
                <select name="type" id="type" class="form-control">
                  <option value="1">Investigation</option>
                  <option value="2">Doctor Appoinment</option>
                </select>
            </div> 
        </div>
        <div class="col-md-6">
            <div id="invstigations">
                <?php 
                    $Investigations = Investigations::find()->where('status = 1')->all();
                    $listData=ArrayHelper::map($Investigations,'id','investigation_name');
                    echo $form->field($model, 'investigation_id')->widget(Select2::classname(), [
                        'data' => $listData,
                        'options' => ['placeholder' => 'Select  ...'],
                        'pluginOptions' => [
                            'tags' => true
                        ],
                    ]); 
                ?>
            </div>
            <div id="doctor">
                <?php 

                $details=DoctorsDetails::find()->where(["status"=>1,"hospital_clinic_id"=>Yii::$app->user->identity->id])->all();

                $listData=ArrayHelper::map($details,'id','name');
                echo $form->field($model, 'doctor_id')->dropDownList(
                    $listData,
                    ['prompt'=>'Select Doctor...','disabled' => true]
                    )->label('Doctor');
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6" style="margin-top: 25px;">
            <?php $model->sunday_holiday = true; echo $form->field($model, 'sunday_holiday')->checkbox(['checked' => true]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php
                echo $form->field($model, 'status')->dropDownList(
                    ['1' => 'Active', '0' => 'Inactive']
            ); ?>
        </div>
    </div>
    <div class="m-t-20 text-center">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs("
    $(document).ready(function() {
        $('select').on('change', function() {
          var option = this.value;
          if(option == 2)
          {
            $('#hospitaldetailflag').prop('checked', false);
          }else{

          }
        });
    });
")
?>

