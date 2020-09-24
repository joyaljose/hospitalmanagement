<?php
use yii\helpers\Html;
//use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\helpers\ArrayHelper;
use common\models\Investigations;
use common\models\DoctorsDetails;
use kartik\select2\Select2;
?>

<div class="content">
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
            <div class="form-group field-schedule-type has-success">
                <label class="control-label" for="type">Choose a Type:</label>
                <select name="type" id="type" class="form-control">
                  <option value="1">Investigation</option>
                  <option value="2">Doctor Appoinment</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div id="doctor" style="display: none;">
                <?php $details=DoctorsDetails::find()->where(["status"=>1,"hospital_clinic_id"=>Yii::$app->user->identity->id])->all();

                $listData=ArrayHelper::map($details,'id','name');
                echo $form->field($model, 'doctor_id')->dropDownList(
                    $listData,
                    ['prompt'=>'Select Doctor...']
                    )->label('Doctor');
                    ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" id="investigation">
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
        <div class="col-md-6" id="amount">
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
            <span id="amounterror" style="color: red;display: none;">Please enter amount</span>
        </div>
    </div>
    <!-- <div class="row">
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
                
            </div>
            <div id="doctor"> -->
                <?php 

                /*$details=DoctorsDetails::find()->where(["status"=>1,"hospital_clinic_id"=>Yii::$app->user->identity->id])->all();

                $listData=ArrayHelper::map($details,'id','name');
                echo $form->field($model, 'doctor_id')->dropDownList(
                    $listData,
                    ['prompt'=>'Select Doctor...','disabled' => true]
                    )->label('Doctor');*/
                ?>
          <!--   </div>
        </div>
    </div> -->
    <!-- <div class="row">
        <div class="col-md-6"> -->
            <?php //$form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        <!-- </div>
        <div class="col-md-6" style="margin-top: 25px;"> -->
            <?php //$model->sunday_holiday = true; echo $form->field($model, 'sunday_holiday')->checkbox(['checked' => true]);
            ?>
       <!--  </div>
    </div>
    <div class="row">
        <div class="col-md-6"> -->
            <?php
                /*echo $form->field($model, 'status')->dropDownList(
                    ['1' => 'Active', '0' => 'Inactive']
            );*/ ?>
        <!-- </div>
    </div>
    <div class="m-t-20 text-center">
        <div class="form-group">
            <?php //Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        </div>
    </div> -->

    <?php ActiveForm::end(); ?>

</div>
    <div class="row">
        <div class="col-sm-8 col-4">
<!--             <h4 class="page-title">Calendar</h4>
 -->        </div>
        <div class="col-sm-4 col-8 text-right m-b-30">
            <a href="#" id ="add_schedule_button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#add_schedule_event" style="display: none;"><i class="fa fa-plus"></i> Add Schedule</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box mb-0">
                <div class="row">
                    <div class="col-md-12">
                        <div id="schedule_calendar"></div>
                    </div>
                </div>
            </div>
            <div id="schedule-modal" class="modal fade" role="dialog" style="overflow: inherit;">
                <div class="modal-dialog">
                    <div class="modal-content modal-lg">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Schedule</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="height: 95px;">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="add_schedule_event" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-lg">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Schedule</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!-- <form> -->
                                <div class="form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" id="eventDate">
                                    </div>
                                    <span id="dateerror" style="color: red;display: none;">Please Select Date</span>

                                </div>
                                <div class="form-group">
                                    <label>Slots <span class="text-danger">*</span></label>
                                    <!-- <input class="form-control" type="text" id="eventName"> -->
                                    <select name="slot[]" id="slot" multiple="multiple" class="form-control">
                                      <option value="">Select</option>
                                      <option value="7.30-8.00">7.30 AM - 8.00 AM</option>
                                      <option value="8.00-8.30">8.00 AM - 8.30 AM</option>
                                      <option value="8.30-9.00">8.30 AM - 9.00 AM</option>
                                      <option value="9.00-9.30">9.00 AM - 9.30 AM</option>
                                      <option value="9.30-10.00">9.30 AM - 10.00 AM</option>
                                      <option value="10.00-10.30">10.00 AM - 10.30 AM</option>
                                      <option value="10.30-11.00">10.30 AM - 11.00 AM</option>
                                      <option value="11.00-11.30">11.00 AM - 11.30 AM</option>
                                      <option value="11.30-12.00">11.30 AM - 12.00 AM</option>
                                      <option value="12.00-12.30">12.00 PM - 12.30 PM</option>
                                      <option value="12.30-13.00">12.30 PM - 01.00 PM</option>
                                      <option value="13.00-13.30">01.00 PM - 01.30 PM</option>
                                      <option value="13.30-14.00">01.30 PM - 02.00 PM</option>
                                      <option value="14.00-14.30">02.00 PM - 02.30 PM</option>
                                      <option value="14.30-15.00">02.30 PM - 03.00 PM</option>
                                      <option value="15.00-15.30">03.00 PM - 03.30 PM</option>
                                      <option value="15.30-16.00">03.30 PM - 04.00 PM</option>
                                      <option value="16.00-16.30">04.00 PM - 04.30 PM</option>
                                      <option value="16.30-17.00">04.30 PM - 05.00 PM</option>
                                      <option value="17.00-17.30">05.00 PM - 05.30 PM</option>
                                      <option value="17.30-18.00">05.30 PM - 06.00 PM</option>
                                      <option value="18.00-18.30">06.00 PM - 06.30 PM</option>
                                      <option value="18.30-19.00">06.30 PM - 07.00 PM</option>
                                      <option value="19.00-19.30">07.00 PM - 07.30 PM</option>
                                    </select>
                                    <span id="sloteerror" style="color: red;display: none;">Please Select One Slot</span>
                                </div>
                                <div class="m-t-20 text-center">
                                    <button class="btn btn-primary submit-btn">Create Schedule</button>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/*.fc-time{
    display:none;
}*/
#add_schedule_event{
    opacity: 1;
}
#schedule-modal {
    opacity: 1;
    margin-top: 15%;
}
</style>
<script type="text/javascript">
    var defaultEvents;
    var baseurl = "<?php print \yii\helpers\Url::base() . "/"; ?>";
    var basepath = "<?php print \yii\helpers\Url::base(); ?>";
    var curl = "<?php print Yii::$app->request->absoluteUrl; ?>";

</script>
<?php
$this->registerJs("
$(document).ready(function(){          
        //$('#slot').multiselect();
        $('#type').on('change',function(e){
            var type = $('#type').val();
            if(type == 1){
                $('#doctor').css('display','none');
                $('#amount').css('display','block');
                $('#investigation').css('display','block');
            }else{
                $('#doctor').css('display','block');
                $('#amount').css('display','none');
                $('#investigation').css('display','none');
            }
        });
        $('.submit-btn').on('click',function(e){
            var type = $('#type').val();
            if(type == 1){
                e.preventDefault();
                var eventDate = $('#eventDate').val();
                if(eventDate == '')
                {
                    $('#dateerror').css('display','block');
                    return false;
                }else{
                    $('#dateerror').css('display','none');
                }
                var amount = $('#schedule-amount').val();
                var investigation = $('#schedule-investigation_id').val();
                var slots = $('#slot').val(); 
                if(slots == '' || slots == null){
                    $('#sloteerror').css('display','block');
                    return false;
                }else{
                    $('#sloteerror').css('display','none');
                }
                if(amount == '')
                {
                    $('#add_schedule_event').modal('hide')
                    $('#amounterror').css('display','block');
                    return false;
                }else
                {
                    $('#amounterror').css('display','none');
                } 
                $.ajax({
                     url:baseurl+'schedule/schedule',
                     data:{'eDate':eventDate,'slots':slots,'investigation':investigation,'amount':amount},
                     type:'POST',
                     success:function(data){
                        // $('#accordion').html(data);
                        // alert(data);
                        window.location.href = '';
                     },
                     error:function(){
                     }
                });
            }else{
                e.preventDefault();
                var eventDate = $('#eventDate').val();
                if(eventDate == '')
                {
                    $('#dateerror').css('display','block');
                    return false;
                }else{
                    $('#dateerror').css('display','none');
                }
                var doctor = $('#schedule-doctor_id').val();
                var slots = $('#slot').val(); 
                if(slots == '' || slots == null){
                    $('#sloteerror').css('display','block');
                    return false;
                }else{
                    $('#sloteerror').css('display','none');
                }
                $.ajax({
                     url:baseurl+'schedule/doctor-schedule',
                     data:{'eDate':eventDate,'slots':slots,'doctor':doctor},
                     type:'POST',
                     success:function(data){
                        // $('#accordion').html(data);
                        // alert(data);
                        window.location.href = '';
                     },
                     error:function(){
                     }
                });
            }
        });
        $('#schedule-investigation_id').on('change', function() {
            var option = this.value;
            $('#add_schedule_button').css('display','block');
            $.ajax({
                url:baseurl+'schedule/get-investigation-schedule',
                data:{'option':option},
                type:'POST',
                success:function(data){
                    var result = JSON.parse(data);
                    if(typeof(result[0]) != 'undefined') 
                    {                    
                        $('#schedule-amount').val(result[0]['amount']);
                    }else
                    {
                        $('#schedule-amount').val(null);
                    }
                    $.each($('#schedule_calendar').fullCalendar('clientEvents'), function (i, item) {
                     $('#schedule_calendar').fullCalendar('removeEvents', item.id);
                    });
                    $.CalendarApp1.init();
                },
                error:function(){
                }
            });
        });

        $('#schedule-doctor_id').on('change', function() {
            $.each($('#schedule_calendar').fullCalendar('clientEvents'), function (i, item) {
             $('#schedule_calendar').fullCalendar('removeEvents', item.id);
            });
            $.CalendarApp1.init();
            $('#add_schedule_button').css('display','block');
        });

});

");
        ?>