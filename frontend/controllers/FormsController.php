<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Forms;
use frontend\models\FormsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\ForumsAnswers;

/**
 * FormsController implements the CRUD actions for Forms model.
 */
class FormsController extends Controller {

        /**
         * @inheritdoc
         */
        public function behaviors() {
                return [
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ];
        }

        /**
         * Lists all Forms models.
         * @return mixed
         */
        public function init() {
                if (!isset(Yii::$app->user->identity)) {
                        $this->redirect(Url::base() . '/site/login');
                } elseif (Yii::$app->user->identity->role != 1) {
                        $this->redirect(Url::base() . '/site/login');
                } elseif (!Yii::$app->studentsLog->checktokenstate(Yii::$app->user->identity->id, Yii::$app->session['multi_token'])) {
                        Yii::$app->studentsLog->loging(Yii::$app->user->identity->id, 'logged out');
                        Yii::$app->user->logout();
                        Yii::$app->parent->logout();
                        return $this->goHome();
                } else {

                        $this->layout = 'loggedstudent';
                        Yii::$app->params['active'] = 'forums';
                }
        }

        public function actionIndex() {
                $this->layout = 'loggedstudent';
                Yii::$app->params['active'] = 'forums';
                $searchModel = new FormsSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        public function actionMyQuestions() {
                $this->layout = 'loggedstudent';
                Yii::$app->params['active'] = 'forums';
                $model = new FormsSearch();
                return $this->render('myForms', [
                            'model' => $model,
                ]);
        }

        /**
         * Displays a single Forms model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new Forms model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {

                $model = new Forms();

                $model->cb = Yii::$app->user->identity->id;
                $model->status = 1;
                $model->cod = date('Y-m-d :h:i:s');
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['index']);
                } else {
                        return $this->render('create', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Updates an existing Forms model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                } else {
                        return $this->render('update', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Deletes an existing Forms model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        public function actionQuestionDetails($id) {

                $question = $this->findModel($id);
                $forumnsComts = New ForumsAnswers();

                return $this->render('detailFourm', [
                            'question' => $question, 'forumnsComts' => $forumnsComts
                ]);
        }

        /**
         * Finds the Forms model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Forms the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = Forms::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

}
