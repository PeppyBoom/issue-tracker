<?php
namespace frontend\controllers;

use common\behaviors\RolePermission;
use frontend\models\Issue;
use frontend\models\search\IssueSearch;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
            'rolePermission' => [
                'class' => RolePermission::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
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
    public function actionIndex()
    {
        if (isset(Yii::$app->request->post()['selection'])) {
            foreach (Yii::$app->request->post()['selection'] as $item) {
                $model = $this->findModel($item);
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    if (isset(Yii::$app->request->post()['Issue'][$item]['name'])) {
                        $model->name = Yii::$app->request->post()['Issue'][$item]['name'];
                    }
                    if (isset(Yii::$app->request->post()['Issue'][$item]['solution'])) {
                        $model->solution = Yii::$app->request->post()['Issue'][$item]['solution'];
                    }
                    $model->rating = Yii::$app->request->post()['Issue'][$item]['rating'];
                    $model->save();
                }
            }
        }

        $searchModel = new IssueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionAdd()
    {
        $model = new Issue();
        $model->save();
        return $this->redirect('/');
    }

    public function actionDelete()
    {
        if (isset(Yii::$app->request->post()['selection'])) {
            foreach (Yii::$app->request->post()['selection'] as $item) {
                Issue::deleteAll(['id' => $item]);
            }
        }
        return $this->redirect(Url::previous());
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
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
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $this->assignRoleAndPermission($user);
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
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
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Issue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function assignRoleAndPermission($user)
    {
        //администратор
        if (!empty(Yii::$app->authManager->getRole('admin')) && 'admin' == Yii::$app->user->identity->username) {
            $userRole = Yii::$app->authManager->getRole('admin');
            Yii::$app->authManager->assign($userRole, $user->getId());
            $userRight = Yii::$app->authManager->getPermission('changeNameAndSolution');
            Yii::$app->authManager->assign($userRight, $user->getId());
        }
        //остальные пользователи
        if (!empty(Yii::$app->authManager->getRole('user')) && 'admin' !== Yii::$app->user->identity->username) {
            $userRole = Yii::$app->authManager->getRole('user');
            Yii::$app->authManager->assign($userRole, $user->getId());
            $userRight = Yii::$app->authManager->getPermission('changeRating');
            Yii::$app->authManager->assign($userRight, $user->getId());
        }
    }
}
