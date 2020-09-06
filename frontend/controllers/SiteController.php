<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\StudentLoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use frontend\models\Students;
use yii\web\Response;
use common\models\ImageForm;
use common\models\Visitors;
use backend\models\WeRecommend;
use backend\models\Subjects;

/**
 * Site controller
 */
class SiteController extends Controller {

        /**
         * @inheritdoc
         */
        public function behaviors() {
                return [
                    'access' => [
                        'class' => AccessControl::className(),
                        'only' => ['logout', 'signup'],
                        'rules' => [
                            [
                                'actions' => ['signup'],
                                'allow' => true,
                                'roles' => ['?'],
                            ],
                            [
                                'actions' => ['logout'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'logout' => ['post'],
                        ],
                    ],
                ];
        }

        /**
         * @inheritdoc
         */
        public function actions() {
                return [
                    'error' => [
                        'class' => 'yii\web\ErrorAction',
                    ],
                    'captcha' => [
                        'class' => 'yii\captcha\CaptchaAction',
                        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                    ],
                ];
        }

        /**
         * Displays homepage.
         *
         * @return mixed
         */
        public function actionIndex() {
                if (!Yii::$app->user->isGuest) {
                        $ip = $this->getUserIP();
                        $this->ipTrack($ip, "registereduser");
                        return $this->redirect(['students/my-account']);
                } if (Yii::$app->user->isGuest) {
                        $ip = $this->getUserIP();
                        $this->ipTrack($ip, "home");

                        return $this->render('index');
                }
        }

        /**
         * Logs in a user.
         *
         * @return mixed
         */
        public function actionLogin() {
                if (!Yii::$app->user->isGuest) {
                        return $this->goHome();
                }

                $ip = $this->getUserIP();
                $this->ipTrack($ip, "Login");

                $model = new StudentLoginForm();
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                        $stdmodel = Students::find()->where(['id' => Yii::$app->user->identity->id])->one();
                        $stdmodel->multi_token = sha1(date('Y-m-d:H:i:s'));
                        if ($stdmodel->save(false)) {
                                Yii::$app->session['multi_token'] = $stdmodel->multi_token;
                        } else {
                                Yii::$app->params['multi_token'] = "";
                        }

                        Yii::$app->studentsLog->loging(Yii::$app->user->identity->id, 'logged in');
                        return $this->redirect(['students/my-account']);
                } else {
                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Logs out the current user.
         *
         * @return mixed
         */
        public function actionLogout() {
                Yii::$app->studentsLog->loging(Yii::$app->user->identity->id, 'logged out');
                Yii::$app->user->logout();
                Yii::$app->parent->logout();
                return $this->goHome();
        }

        public function actionWeRecommend() {
                $we_recommends = WeRecommend::find()->where(['status' => 1])->all();
                return $this->render('weRecommend', [
                            'we_recommends' => $we_recommends,
                ]);
        }

        public function actionBookIndex() {
                $subjects = Subjects::find()->where(['status' => 1])->all();

                return $this->render('books', ['subjects' => $subjects]);
        }

        public function actionTermsCondition() {


                return $this->render('termsAndConditions');
        }

        /**
         * Displays contact page.
         *
         * @return mixed
         */
        public function actionContactus() {
                $model = new ContactForm();
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                        if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                        } else {
                                Yii::$app->session->setFlash('error', 'There was an error sending email.');
                        }

                        return $this->refresh();
                } else {

                        return $this->render('contact', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Displays about page.
         *
         * @return mixed
         */
        public function actionAboutus() {
                return $this->render('about');
        }

        public function actionDisclaimer() {
                return $this->render('disclaimer');
        }

        public function actionServices() {
                return $this->render('services');
        }

        public function actionRegister() {
                $model = new Students();

                $ip = $this->getUserIP();
                $this->ipTrack($ip, "register");
                if ($model->load(Yii::$app->request->post())) {
                        $model->role = 1;

                        if ($model->dob) {
                                $model->dob = date('Y-m-d', strtotime($model->dob));
                        }
                        // $transaction = Yii::$app->db->beginTransaction();
                        if ($model->register()) {

                                try {

                                        /* $this->sendMail($model);
                                          $transaction->commit();
                                          Yii::$app->session->setFlash('register', "Congratulations!.. please re-login on mastermbbs.com with your email and password to complete the registration process");
                                          return $this->redirect(['site/login']); */
                                        return $this->redirect(['student-plan/all-plans', 'id' => $model->id]);
                                } catch (\Swift_TransportException $e) {
                                        $transaction->rollBack();
                                        Yii::$app->session->setFlash('registerError', $e . "Sorry!.. have some connectivity issue please try later");
                                        return $this->redirect(['site/register']);
                                } catch (\Exception $e) {
                                        $transaction->rollBack();
                                        Yii::$app->session->setFlash('registerError', $e . " Sorry!.. have some connectivity issue please try later");
                                        return $this->redirect(['site/register']);
                                }
                        }
                }
                return $this->render('register', ['model' => $model]);
        }

        /**
         * Signs user up.
         *
         * @return mixed
         */

        /**
         * Requests password reset.
         *
         * @return mixed
         */
        public function actionRequestPasswordReset() {

                $model = new PasswordResetRequestForm();
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        if ($model->sendEmail()) {
                                Yii::$app->session->setFlash('spr', 'Check your email for further instructions.');
                                $url = Yii::$app->request->baseUrl . '/site/request-password-reset';
                                // return $this->redirect($url);
                        } else {
                                Yii::$app->session->setFlash('epr', 'Sorry, we are unable to reset password for email provided.');
                        }
                }
                return $this->render('requestPasswordResetToken', [
                            'model' => $model,
                ]);
        }

        /**
         * Resets password.
         *
         * @param string $token
         * @return mixed
         * @throws BadRequestHttpException
         *
         *
         */
        public function actionActivation() {
                if (filter_input(INPUT_GET, 'auth') !== null && filter_input(INPUT_GET, 'username') !== null) {
                        $studentsDetails = Students::find()
                                ->where(['auth_key' => filter_input(INPUT_GET, 'auth')])
                                ->andWhere(['user_id' => filter_input(INPUT_GET, 'username')])
                                ->one();
                        if (count($studentsDetails) < 0) {
                                Yii::$app->session->setFlash('activation', 'Opps!..Please register again! Something went wrong');
                                return $this->redirect(['site/register']);
                        } elseif ($studentsDetails->status == 10) {
                                Yii::$app->session->setFlash('activation', 'Great!... you had already registered.Please login');
                                return $this->redirect(['site/login']);
                        } elseif ($studentsDetails->status == 1) {
                                $studentsDetails->status = 10;
                                $studentsDetails->save(false);
                                Yii::$app->session->setFlash('activation', 'Congratulations!..Your account has been activated. Please login.');
                                return $this->redirect(['site/login']);
                        } else {
                                Yii::$app->session->setFlash('activated', 'Something went wrong.Please try again or contact mastermbbs');
                                return $this->redirect(['site/login']);
                        }
                } else {
                        Yii::$app->session->setFlash('activated', 'Something went wrong.Please try again or contact mastermbbs');
                        return $this->redirect(['site/login']);
                }
        }

        public function actionResetPassword($token) {
                try {
                        $model = new ResetPasswordForm($token);
                } catch (InvalidParamException $e) {
                        throw new BadRequestHttpException($e->getMessage());
                }
                if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {


                        Yii::$app->session->setFlash('success', 'New password was saved.');
                        $url = Yii::$app->request->baseUrl . '/site/login';
                        return $this->redirect($url);
                        //return $this->goHome();
                }

                return $this->render('resetPassword', [
                            'model' => $model,
                ]);
        }

        public function actionLoadStates() {
                $this->layout = FALSE;
                Yii::$app->response->format = Response::FORMAT_JSON;
                $state = [];

                if (filter_input(INPUT_POST, 'countryid') !== NULL && filter_input(INPUT_POST, 'countryid') > 0) {
                        $state = \yii\helpers\ArrayHelper::map(\frontend\models\States::find()
                                                ->select(['id', 'state_name'])
                                                ->where(['country_id' => filter_input(INPUT_POST, 'countryid')])
                                                ->andWhere(['status' => 1])->all(), 'id', 'state_name');
                }
                return $state;
        }

        public function actionParentLogin() {

                if (!Yii::$app->parent->isGuest) {
                        return $this->redirect(['parents/index']);
                }

                $model = new \frontend\models\parentLoginForm();
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                        return $this->redirect(['parent/index']);
                } else {
                        return $this->render('login', [
                                    'model' => $model,
                        ]);
                }
        }

        public function sendMail($model) {

                \Yii::$app->mailer->compose('registerMail', ['model' => $model])
                        ->setFrom([\Yii::$app->params['supportEmail'] => 'mastermbbslearn@gmail.com'])
                        ->setTo($model->user_id)
                        ->setSubject('Welcome to mastermbbs')
                        ->send();
        }

        public function actionImageUpload() {
                $this->layout = false;
                $targetFolder = \yii::$app->basePath . '/../uploads/students/profiles/';
                //print_r($targetFolder); exit();
                if (!file_exists($targetFolder)) {
                        mkdir($targetFolder, 0777, true);
                }
                $model = new ImageForm();
                if (isset($_POST['image']) && $_POST['image'] != "") {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        $data = $_POST['image'];
                        list($type, $data) = explode(';', $data);
                        list(, $data) = explode(',', $data);
                        $data = base64_decode($data);
                        $imageName = time() . '.png';
                        if (file_put_contents($targetFolder . $imageName, $data)) {
                                return ['response' => 'success', 'image' => $imageName];
                        } else {
                                return ['response' => 'error'];
                        }

                        yii::$app->end();
                }
                return $this->renderAjax('image', [
                            'model' => $model,
                ]);
        }

        public function getUserIP() {
                $client = @$_SERVER['HTTP_CLIENT_IP'];
                $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
                $remote = $_SERVER['REMOTE_ADDR'];

                if (filter_var($client, FILTER_VALIDATE_IP)) {
                        $ip = $client;
                } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
                        $ip = $forward;
                } else {
                        $ip = $remote;
                }

                return $ip;
        }

        public function ipTrack($ip, $action) {
                $model = new Visitors();
                $model->ip_address = $ip;
                $model->action = $action;
                if ($model->save()) {
                        return TRUE;
                }
//                else {
//                    print_r($model->getErrors());exit;
//                     }
        }

}