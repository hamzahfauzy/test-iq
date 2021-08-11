<?php

namespace app\controllers\rest\v1;

use Yii;
use app\models\Exam;
use app\models\User;
use app\models\Category;
use yii\rest\Controller;
use app\models\Participant;
use yii\filters\auth\HttpBearerAuth;

class DashboardController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        
        $behaviors['authenticator'] = [
            'class' =>  HttpBearerAuth::className(),
            'except' => ['options'],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $participant = Yii::$app->user->identity->participant;
        $examParticipants = $participant->getExamParticipants()->select(['exam_id','status'])->asArray()->all();
        $tutorial = [
            'group_1' => 'http://video.ujiantmc.online/vmb1',
            'group_2' => 'http://video.ujiantmc.online/vmb2',
            'group_3' => 'http://video.ujiantmc.online/vmb3',
            'group_4' => 'http://video.ujiantmc.online/vmb4',
            'group_5' => 'http://video.ujiantmc.online/vmb5',
        ];
        foreach($examParticipants as $key => $ex)
        {
            $exam = Exam::find()->where(['id'=>$ex['exam_id']])->asArray()->one();
            $now = strtotime('now');
            $exam['tutorial'] = $tutorial[$exam['test_group']];
            $exam['in_time'] = strtotime($exam['start_time']) <= $now && strtotime($exam['end_time']) >= $now;
            $examParticipants[$key]['exam'] = $exam;

        }
        
        return [
            'participant' => $participant,
            'exams' => $examParticipants
        ];
    }
}