<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Response;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Participant;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ExamParticipant;
use Spipu\Html2Pdf\Html2Pdf;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = "main-login";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    function actionLaporan($token)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::findIdentityByAccessToken($token);
        $peserta = Participant::findOne($user->participant->id);
        $examParticipant = $peserta->examParticipant;
        $participant = Participant::find()->where([
                    'participants.id'=>$examParticipant->participant_id,
                ])
                ->joinWith([
                    'examAnswers' => function($q) use ($examParticipant){
                        $q->andWhere(['exam_id' => $examParticipant->exam_id]);
                    },
                    'examAnswers.answer',
                    'examAnswers.question',
                    'examAnswers.question.items',
                    'examAnswers.question.categoryPost'
                ])->asArray()->one();
        // return $model;
        if(!isset($participant['examAnswers']))
        {
            echo "tidak ada file";
            return;
        }
        $report = [];
        $score = ['CFIT'=>0,'Papikostick'=>""];
        foreach($participant['examAnswers'] as $answer)
        {
            // CFIT -> score add 
            // PAPICOSTIC
            $cfit = ['CFIT 1','CFIT 2','CFIT 3','CFIT 4'];
            if(in_array($answer['question']['categoryPost']['name'],$cfit))
            {
                if($answer['answer'])
                    $score['CFIT'] += (int) $answer['answer']['post_type'];
                else
                {
                    $question_answer = $answer['question']['items'][0];
                    $score['CFIT'] += $answer['answer_content'] == $question_answer['post_content'] ? 1 : 0;
                }
            }
            elseif(isset($score[$answer['question']['categoryPost']['name']]))
                $score[$answer['question']['categoryPost']['name']] .= $answer['answer']['post_type'];
        }
        unset($participant['examAnswers']);
        $papikosticks = $score['Papikostick'];
        $papikosticks = str_split($papikosticks);
        $p_v = [
            "G"=>0,
            "A"=>0,
            "N"=>0,
            "F"=>0,
            "Z"=>0,
            "E"=>0,
            "S"=>0,
            "O"=>0,
            "L"=>0,
            "P"=>0,
            "I"=>0,
        ];
        foreach($papikosticks as $p)
            if(isset($p_v[$p])) $p_v[$p]++;
            
        $score['Papikostick'] = $p_v;

        $participant['score'] = $score;

        // header("Content-type: application/vnd-ms-excel");
        // header("Content-Disposition: attachment; filename=Report-".$model['name'].".xls");

        $content = $this->renderPartial('report', [
            'participant' => $participant,
            'peserta' => $peserta,
        ]);

        // return $content;

        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($content);
        $html2pdf->output();
    }
}
