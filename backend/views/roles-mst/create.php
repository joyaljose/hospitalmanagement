<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RolesMst */

$this->title = 'Create Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Create Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roles-mst-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
