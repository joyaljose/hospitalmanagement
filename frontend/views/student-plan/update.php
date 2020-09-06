<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\StudentPlan */

$this->title = 'Update Student Plan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-plan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>