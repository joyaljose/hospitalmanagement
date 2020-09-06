<?php

use yii\helpers\Url;

$profileImagePath = Url::base() . '/uploads/profilepic/' . Yii::$app->user->identity->id . '/';
$demoImage = Url::base() . '/images/demo.jpg';
?>

<div class="col-md-4 mbb">
        <div class="mbbs-left">
                <img class="center-block demo" src="<?= ($model->profile_image) ? $profileImagePath . $model->profile_image : $demoImage ?>">
                <ul>
                        <!--   <li><a href="#">Study</a></li>-->
                        <!--<li><a href="#">bookmarks</a></li>-->
                        <!--  <li><a href="#">Posts</a></li>-->
                        <li><a class="updatesoon" href="<?= Url::base() . '/forms/' ?>">Questions</a></li>
                        <li><a class="updatesoon" href="<?= yii::$app->urlManager->createUrl(['posts/latest-post']) ?>">Latest post</a></li>
                        <li><a class="updatesoon" href="#">Plan Details</a></li>

                        <li class="active"><a href="<?= yii::$app->urlManager->createUrl(['students/update']) ?>">Edit profile</a></li>
                </ul>
        </div>
</div>


<?php
yii\bootstrap\Modal::begin([
    'id' => 'updatesoon',
]);
/* echo '<div id="status"><p>We are on the way of updating the contents.<br/>'
  . 'Your understanding and patience is greatly appreciated .</p></div>'; */
echo '<div id="status"><p><a href="https://www.facebook.com/MasterMBBS/" target="_blank">Mastermbbs</a> is a site committed to making medical learning easy and fun.<br/>'
 . ' So do write in and tell us how you would like this feature to be made for you.</p></div>';
yii\bootstrap\Modal::end();

$this->registerJs("
        $('.updatesoon').on('click',function(e){
                e.preventDefault();
                $('#updatesoon').modal('show');

        });
");