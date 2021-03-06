<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PatientDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patient Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'last_name',
            'email:email',
            'phone',
            'profile_image:ntext',
            'address:ntext',
            'age',
            'gender',
            'state',
            'district',
            'city',
            'area',
            'status',
            'refer_id',
            'latitude',
            'longitude',
            'created_on',
            'otp',
        ],
    ]) ?>

</div>
