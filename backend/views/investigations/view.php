<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Investigations */

$this->title = $model->investigation_name;
$this->params['breadcrumbs'][] = ['label' => 'Investigations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="investigations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('Delete', ['delete', 'id' => $model->id], [
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
            //'id',
            [                                                  // the owner name of the model
                'label' => 'Category',
                'value' => $model->category->category_name,          
            ],
            'investigation_name',
            [                                                  // the owner name of the model
                'label' => 'Status',
                'value' => ($model->status == 1)?'Active':'Inactive'          
            ],
            'created_on',
            [                                                  // the owner name of the model
                'label' => 'created_by_type',
                'value' => ($model->created_by_type == 1)?'Admin':'Hospital/Clinic'          
            ],
        ],
    ]) ?>

</div>