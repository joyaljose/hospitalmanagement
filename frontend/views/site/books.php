<section class="books">
        <div class="container">
                <div class="row">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">

                                <h4 class="book-head">click on a topic to see individual classes</h4>
                                <div class="accordion-wrp1">

                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


                                                <?php
                                                $i = 0;
                                                foreach ($subjects as $subject) {
                                                        $i++;

                                                        $chapters = backend\models\Chapters::find()->where(['sub_id' => $subject->sub_id])->all();
                                                        ?>

                                                        <div class="panel panel-default">
                                                                <div class="panel-heading parent" role="tab" id="heading<?= $i ?>">
                                                                        <h4 class="panel-title">
                                                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>" aria-expanded="true" aria-controls="collapse<?= $i ?>">
                                                                                        <?= $subject->sub_name; ?>
                                                                                        <span></span>
                                                                                </a>
                                                                        </h4>
                                                                </div>
                                                                <div id="collapse<?= $i ?>" class="panel-collapse collapse <?= ($i == 1) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading<?= $i ?>">
                                                                        <div class="panel-body">


                                                                                <div class="accordion-wrp2">
                                                                                        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">



                                                                                                <?php
                                                                                                $j = 0;

                                                                                                foreach ($chapters as $chapter) {
                                                                                                        $j++;
                                                                                                        $topics = \backend\models\Topics::find()->where(['chapter_id' => $chapter->chapter_id])->all();
//
                                                                                                        ?>

                                                                                                        <div class="panel panel-default">
                                                                                                                <div class="panel-heading" role="tab" id="heading<?= $i ?><?= $j ?>">
                                                                                                                        <h4 class="panel-title">
                                                                                                                                <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?= $i ?><?= $j ?>" aria-expanded="true" aria-controls="collapse<?= $i ?><?= $j ?>">
                                                                                                                                        <span></span>
                                                                                                                                        <?= $chapter->chapter_name; ?>

                                                                                                                                </a>
                                                                                                                        </h4>
                                                                                                                </div>
                                                                                                                <div id="collapse<?= $i ?><?= $j ?>" class="panel-collapse collapse <?= ($j == 1) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="heading<?= $i ?><?= $j ?>">
                                                                                                                        <?php /* <div class="panel-body">


                                                                                                                          <ul class="list-unstyled">
                                                                                                                          <?php foreach ($topics as $topic) { ?>
                                                                                                                          <li><i class="fa fa-circle"></i> <a href="#"><?= $topic->topic; ?></a></li>
                                                                                                                          <?php } ?>
                                                                                                                          </ul>

                                                                                                                          </div> */ ?>

                                                                                                                        <div class="panel-body">


                                                                                                                                <ul class="list-unstyled">
                                                                                                                                        <?php foreach ($topics as $topic) { ?>
                                                                                                                                                <li><i></i> <a href="javascript::void(0)"><?php echo $topic->topic; ?></a></li>

                                                                                                                                        <?php } ?>
                                                                                                                                </ul>

                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>

                                                                                                <?php } ?>



                                                                                        </div>
                                                                                </div>

                                                                        </div>
                                                                </div>
                                                        </div>

                                                <?php } ?>





                                        </div>
                                </div>





                        </div>
                </div>
        </div>
</section>