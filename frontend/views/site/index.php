<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "mastermbbs.com"
?>

<style>
        .pose1 {
                position: relative;
                overflow: hidden;
                float: left;
                margin-top: 15px;
                margin-bottom: 15px;
                height: 240px;
                width: 100%;
        }

</style>
<section class="banner">
        <a href="indexs.php"></a>
        <div class="mbbs_video">
                <div class="bn-img">
                        <img class="img-responsive" src="<?= Yii::$app->request->baseUrl . '/images/bn1.png' ?>">
                </div>
                <div class="mbbs_inner">

                        <div class="log_reg center-block">

                                <p> CREATING MASTER DOCTORS<br/><br/>
                                        Get the first step to being a great doctor right !</p>
                                <div class="ply"> <a href="" data-toggle="modal" data-target="#myModal" style="display:none;"><h3>Watch Video</h3></a>
                                </div>
                                <div style="clear:both"></div>
                        </div>
                </div>
                <img src="<?= Yii::$app->request->baseUrl . '/images/MMBS.jpg' ?>" class="bg_video"/>
                <!-- <video loop muted  autoplay="autoplay"  poster="img/videoframe.jpg" class="bg_video">
                     <source src="<?= Yii::$app->request->baseUrl . '/video/vid.mp4' ?>" type="video/webm">
                     <source src="<?= Yii::$app->request->baseUrl . '/video/vid.mp4' ?>" type="video/mp4">
                     <source src="<?= Yii::$app->request->baseUrl . '/video/vid.mp4' ?>" type="video/ogg">
                 </video>-->
        </div>
        <div class="modal  bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                </div>
                                <div class="modal-body">
                                        <video  controls="controls" muted  autoplay="autoplay" width="100%"  poster="img/videoframe.jpg" >
                                                <source src="<?= Yii::$app->request->baseUrl . '/video/vid.mp4' ?>" type="video/webm">
                                                <source src="<?= Yii::$app->request->baseUrl . '/video/vid.mp4' ?>" type="video/mp4">
                                                <source src="<?= Yii::$app->request->baseUrl . '/video/vid.mp4' ?>" type="video/ogg">
                                        </video>
                                </div>

                        </div>
                </div>
        </div>

</section>


<a href="includes/header.php"></a>


<section class="ui-mains">
        <div class="container">
                <div class="row">
                        <div class="col-md-12">
                                <!--                <h1>Welcome To Master mbbs</h1>-->

                                <nav class="cl-effect-5">
                                        <a href="#"><span data-hover="MBBS  SIMPLIFIED">MBBS  SIMPLIFIED</span></a>

                                </nav>
                                <img class="center-block dots" src="<?= Url::base() . '/images/dots.png' ?>">
                                <p>This site was born out of the desire to simplify
                                        MBBS  learning to  medical students , thereby taking away the stress of transitioning
                                        from the +2 curriculum to the highly demanding MBBS course and to inspire the students to learn medicine with clarity and ease. </p>
                                <p>The whole 1 MBBS course content for Anatomy , Physiology and Biochemistry has been explained in easy to grasp lecture videos to prepare the medical student to face the theory exams with confidence.
                                </p>
                                <p>
                                        The video lectures have been contributed by eminent medical college teaching faculty  who have been selected by an extensive opinion poll conducted among current medical students. These teachers are known for their passion for their respective subjects and for their ability to simplify MBBS learning
                                </p>
                                <!--                <a class="center-block registers" href="#">Register Now</a>-->
                                <nav class="cl-effect-10">
                                        <a class="sez" href="<?= Yii::$app->request->baseUrl . '/site/register' ?>" data-hover="Register Now"><span>Register Now</span></a>
                                </nav>
                        </div>
                </div>
        </div>
</section>
<section class="parallax" id="parallax-1" style="background-position: 50% 0px;">
        <div class="container">
                <div class="row">
                        <!--            <h1>Lorem ipsum dolor</h1>-->

                        <nav class="cl-effect-2">
                          <!--  <a class="success" href="#"><span data-hover="Lorem ipsum dolor sit amet consectetur">Lorem ipsum dolor sit amet consectetur</span></a>-->

                        </nav>

                        <ul class="list-unstyled">
                                <li>The whole syllabus of 1 MBBS covered systematically </li>
                                <li>Easy to follow simplified lectures </li>
                                <li>Over 300 hours of classes </li>
                                <li>Easy to revise format </li>


                                <li>Provides a solid foundation for the soon to be implemented medical Exit exam(NEXT)</li>
                                <li>In course support from faculty  </li>
                                <li>Extensively prepares the student to answer theory questions with ease </li>
                                <li>Previous examination questions  </li>
                                <li>Content upgraded continuously </li>
                        </ul>
                </div>
        </div>
</section>


<section class="ui-videos">
        <div class="container">
                <div class="row">
                        <nav class="cl-effect-5">
                                <a href="#"><span data-hover="Featured Videos">Featured Videos</span></a>
                        </nav>
                        <img class="center-block dots" src="<?= Yii::$app->request->baseUrl . '/images/dots.png' ?>">


                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="pose1">
                                        <iframe src="https://player.vimeo.com/video/194274888"  width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

                                </div>
                                <p>Biochemistry</p>
                                <p>More than 40 videos <a href="<?= Yii::$app->request->baseUrl . '/site/book-index' ?>">View Full Index</a></p>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="pose1">
                                        <iframe src="https://player.vimeo.com/video/199347523"  width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>
                                <p>Anatomy</p>

                                <p>More than 40 videos <a href="<?= Yii::$app->request->baseUrl . '/site/book-index' ?>">View Full Index</a></p>


                        </div>

                        <div class = "col-md-4 col-sm-4 col-xs-12">
                                <div class = "pose1">
                                        <!--<iframe src = "https://player.vimeo.com/video/228606878" width = "100%" height = "100%" frameborder = "0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> -->
                                        <iframe src="https://player.vimeo.com/video/229578303" width="100%" height="100%" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
                                </div>
                                <!--<p>Embryology</p> -->
                                <p>Physiology</p>
                                <p>More than 40 videos <a href="<?= Yii::$app->request->baseUrl . '/site/book-index' ?>">View Full Index</a></p>
                        </div>
                </div>
        </div>
</section>

<section class = "ui-mains">
        <div class = "container">
                <div class = "row">
                        <div class = "col-md-12">
                                <!--<h1>Welcome To Master mbbs</h1> -->

                                <nav class = "cl-effect-5">
                                        <a href = "#"><span data-hover = "How to use">How to use </span></a>

                                </nav>
                                <img class = "center-block dots" src = "<?= Url::base() . '/images/dots.png' ?>" >
                                <span><h3>As per the recommendation of the contributing faculty :</h3></span>
                                <ul class = "list-unstyled">
                                        <li>See the video lectures just before the corresponding topic is taught in your classroom </li>
                                        <li>Revise the relevant video once again after your classroom learning </li>
                                        <li>Review and relearn at least a small portion daily</li>
                                        <li>View again and revise before your internal exams</li>
                                        <li>Use as a fast revision tool before your final exams</li>
                                        <li>If you desire clarification on a certain topic, send in a query</li>
                                </ul>
                                <nav class = "cl-effect-10">
                                        <a class = "sez" href = "<?= Yii::$app->request->baseUrl . '/site/register' ?>" data-hover = "Register Now"><span>Register Now</span></a>
                                </nav>
                        </div>
                </div>
        </div>
</section>
<!--
<section class = "packages hidden-xs">
<div class = "container">
<div class = "row">

<nav class = "cl-effect-5">
<a href = "#"><span data-hover = "Featured Packages">Featured Packages</span></a>
</nav>
<img class = "center-block dots" src = "<?= Yii::$app->request->baseUrl . '/images/dots.png' ?>">
<div class = "col-md-3 col-sm-12">
<div class = "bg-white">
<img class = "hotdeal" src = "<?= Yii::$app->request->baseUrl . '/images/deals.png' ?>">
<h4>Standard</h4>
<div class = "whites">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>
</div>


<div class = "col-md-3 col-sm-12">
<!--<div class = "bg-large">

<img class = "hotdeal" src = "images/deals.png">

<h4>Standard</h4>
<div class = "larges">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>

<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>

<a class = "choses" href = "Chose Now">Chose Now</a>
</div> -->
<!--
<div class = "bg-white">
<img class = "hotdeal" src = "<?= Yii::$app->request->baseUrl . '/images/deals.png' ?>">
<h4>Standard</h4>
<div class = "whites">

<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>




</div>

<div class = "col-md-3 col-sm-12">
<div class = "bg-white">
<img class = "hotdeal" src = "<?= Yii::$app->request->baseUrl . '/images/deals.png' ?>">
<h4>Standard</h4>
<div class = "whites">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>
</div>
<div class = "col-md-3 col-sm-12">
<div class = "bg-white">
<img class = "hotdeal" src = "<?= Yii::$app->request->baseUrl . '/images/deals.png' ?>">
<h4>Standard</h4>
<div class = "whites">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>
</div>



</div>
</div>
</section>




<section class = "packages visible-xs">
<div class = "container">
<div class = "row">

<div class = "mob-packages">
<div class = "item">
<div class = "main">
<div class = "bg-white">
<h4>Standard</h4>
<div class = "whites">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>
</div>
</div>


<div class = "item">
<div class = "main">
<div class = "bg-white">
<h4>Standard</h4>
<div class = "whites">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>
</div>
</div>

<div class = "item">
<div class = "main">
<div class = "bg-white">
<h4>Standard</h4>
<div class = "whites">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>
</div>
</div>
<div class = "item">
<div class = "main">
<div class = "bg-white">
<h4>Standard</h4>
<div class = "whites">
<h2>Starting at</h2>
<nav class = "cl-effect-6">
<a class = "price" href = "#"><span data-hover = "00.00 $">00.00 $</span></a>
</nav>
<h2>Per Month</h2>
</div>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<p>Lorem ipsum dolor sit amet</p>
<a class = "chose" href = "Chose Now">Chose Now</a>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

-->
<!--
<section class = "ui-testimonials">
<div class = "container">
<div class = "row">
<div class = "col-md-12">

<nav class = "cl-effect-5">
<a href = "#"><span data-hover = "Testimonials">Testimonials</span></a>
</nav>
<img class = "center-block dots" src = "<?= Yii::$app->request->baseUrl . '/images/dots.png' ?>">
<div class = "quotes">
<div class = "item">
<div class = "main">
<div class = "talks">
<div class = "talks-1">
<img class = "testi" src = "<?= Yii::$app->request->baseUrl . '/images/quotes.png' ?>">
<h2>John De</h2>
</div>
<div class = "talks-2">
<img class = "men" src = "<?= Yii::$app->request->baseUrl . '/images/m1.jpg' ?>">
</div>
</div>
<div class = "clearfix"></div>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate veli
</p>
</div>
</div>

<div class = "item">
<div class = "main">
<div class = "talks">
<div class = "talks-1">
<img class = "testi" src = "<?= Yii::$app->request->baseUrl . '/images/quotes.png' ?>">
<h2>John De</h2>
</div>
<div class = "talks-2">
<img class = "men" src = "<?= Yii::$app->request->baseUrl . '/images/m2.jpg' ?>">
</div>
</div>
<div class = "clearfix"></div>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate veli
</p>
</div>
</div>

<div class = "item">
<div class = "main">
<div class = "talks">
<div class = "talks-1">
<img class = "testi" src = "<?= Yii::$app->request->baseUrl . '/images/quotes.png' ?>">
<h2>John De</h2>
</div>
<div class = "talks-2">
<img class = "men" src = "<?= Yii::$app->request->baseUrl . '/images/m3.jpg' ?>">
</div>
</div>
<div class = "clearfix"></div>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate veli
</p>
</div>
</div>

<div class = "item">
<div class = "main">
<div class = "talks">
<div class = "talks-1">
<img class = "testi" src = "<?= Yii::$app->request->baseUrl . '/images/quotes.png' ?>">
<h2>John De</h2>
</div>
<div class = "talks-2">
<img class = "men" src = "<?= Yii::$app->request->baseUrl . '/images/m3.jpg' ?>">
</div>
</div>
<div class = "clearfix"></div>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate veli
</p>
</div>
</div>

</div>



</div>
</div>
</div>
</section>
-->



<style type = "text/css">

        #preloader  {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #fefefe;
                z-index: 99;
                height: 100%;
                width:100%;
        }

        #status  {
                width: 200px;
                height: 200px;
                position: absolute;
                left: 50%;
                top: 50%;
                background-image: url(ajax-loader.gif);
                background-repeat: no-repeat;
                background-position: center;
                margin: -100px 0 0 -100px;
        }
        #status img{
                max-width:100%;
        }

</style>
<div id = "preloader">
        <div id = "status"><img src = "<?= Yii::$app->request->baseUrl . '/images/mastermbbs.gif' ?>"/></div>

</div>
<!--<section class = "parallax-small" id = "parallax-2" style = "background-position: 50% 0px;">
        <div class = "container">
                <div class = "row">
                        <div class = "col-md-12 wid">
                                <div class = "test-1">
                                        <h3>Subscribe</h3>
                                        <h4>Newsletter</h4>
                                </div>
                                <div class = "test-2">
                                        <form class = "form-inline" role = "form">
                                                <div class = "form-group">

                                                        <input type = "email" placeholder = "Your Email Address" class = "form-controls" id = "email">
                                                </div>
                                                <button type = "submit" class = "btn btn-default subs"><i class = "fa haha-email fa-send"></i></button>
                                        </form>
                                </div>
                        </div>
                </div>
        </div>
</section> -->


<?php
$this->registerJs("
         jQuery(window).load(function() {
                jQuery('#status').delay(4000).fadeOut();
                jQuery('#preloader').delay(5000).fadeOut('slow');
           })
 ");
?>
