<?php

namespace app\controllers\rest\v1;

use Yii;
use app\models\Exam;
use app\models\User;
use app\models\Category;
use yii\rest\Controller;
use app\models\UserMetas;
use app\models\Participant;
use app\models\ExamParticipant;
use yii\filters\auth\HttpBearerAuth;

class SequenceController extends Controller
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

    public function actionCategories($exam_id)
    {
        $exam = Exam::findOne(['id'=>$exam_id]);
        $group_id = $exam->test_group;
        $jurusan = Yii::$app->user->identity->participant->study;
        $test_group = Yii::$app->params['test_group'];
        $test_group = $test_group[$group_id];
        $tools = $test_group['tools'];
        // if(file_exists($group_id.($jurusan?'-'.$jurusan:'').'.json') && $status==false)
        //     return json_decode(file_get_contents($group_id.'.json'));
        
        $categories = Category::find()
                    ->where([
                        'in', 'test_tool', $tools
                    ])
                    ->orderBy(['sequenced_number'=>'asc'])->all();

        return $categories;
    }

    public function actionSingleCategories($category_id)
    {
        $jurusan = Yii::$app->user->identity->participant->study;
        $categories = Category::find()->where(['categories.id'=>$category_id])
                        ->joinWith(['posts'=>function($q){
                            return $q->select(['id','post_title','post_content','jurusan']);
                        },'posts.items'=>function($q){
                            return $q->select(['id','post_title','post_content','jurusan']);
                        }])
                        ->asArray()
                        ->one();

        $posts = [];
        foreach($categories['posts'] as $post)
        {
            if($categories['test_tool'] == 'IMJ' && strtolower($jurusan) != strtolower($post['jurusan'])) continue;
            if(isset($post['items']) && $categories['test_tool'] == 'TPA')
                shuffle($post['items']);

            $posts[] = $post;
        }
        $categories['posts'] =  $posts;

        return $categories;
    }

    public function actionSingleCategoriesDemo($category_id)
    {
        $jurusan = Yii::$app->user->identity->participant->study;
        $categories = Category::find()->where(['categories.id'=>$category_id])
                        ->joinWith(['posts'=>function($q){
                            return $q->select(['id','post_title','post_content','jurusan']);
                        },'posts.items'=>function($q){
                            return $q->select(['id','post_title','post_content','jurusan']);
                        }])
                        ->asArray()
                        ->one();

        $posts = [];
        foreach($categories['posts'] as $key => $post)
        {
            if($categories['test_tool'] == 'IMJ' && strtolower($jurusan) != strtolower($post['jurusan'])) continue;
            if(isset($post['items']) && $categories['test_tool'] == 'TPA')
                shuffle($post['items']);

            $posts[] = $post;
            break;
        }
        $categories['posts'] =  $posts;

        return $categories;
    }

    public function actionStart(){
        $request = Yii::$app->request;
        $data = $request->post();
        foreach($data as $key => $value)
        {
            $userMetas = new UserMetas;
            $userMetas->user_id = Yii::$app->user->identity->id;
            $userMetas->meta_key = $key;
            $userMetas->meta_value = $value;
            $userMetas->save();
        }

        $participant = Yii::$app->user->identity->participant;
        if(isset($data['tanggal_lahir']))
        {
            $participant->birthdate = $data['tanggal_lahir'];
            $participant->save(false);
        }
        $exam_participant = ExamParticipant::find()->where(['participant_id'=>$participant->id,'exam_id'=>$participant->exam->id])->one();
        $exam_participant->status = 'start';
        $exam_participant->started_at = date('Y-m-d H:i:s');
        $exam_participant->save();
        return ['msg'=>'success'];
    }

    public function actionFinish(){
        $participant = Yii::$app->user->identity->participant;
        $request = Yii::$app->request;
        $data = $request->post();
        $exam_participant = ExamParticipant::find()->where(['participant_id'=>$participant->id,'exam_id'=>$data['id']])->one();
        $exam_participant->status = 'finish';
        $exam_participant->finished_at = date('Y-m-d H:i:s');
        $exam_participant->save();
        return ['msg'=>'success'];
    }

    function actionAnswered($exam_id){
        $user = Yii::$app->user->identity;
        if(file_exists('answers/'.$exam_id.'-'.$user->username.'.json'))
        {
            $data = file_get_contents('answers/'.$exam_id.'-'.$user->username.'.json');
            $data = json_decode($data);
            return $data->answers;
        }
        return [];
    }

    function actionSendAnswer()
    {
        ini_set('upload_max_filesize', '60M');     
        ini_set('max_execution_time', '999');
        ini_set('memory_limit', '128M');
        ini_set('post_max_size', '60M');
        $user = Yii::$app->user->identity;
        $request = Yii::$app->request;
        $data = $request->post();
        $id   = $data['id'];
        $file = "answers/".$id.'-'.$user->username.'.json';
        if(file_exists($file))
        {
            $old_file = file_get_contents($file);
            $old_data = json_decode($old_file);
            $data['answered'] = array_merge($old_data,$data['answered']);
        }
        $data = json_encode($data['answered']);
        file_put_contents($file,$data);
        return $data;
    }

    public function actionSequences($exam_id,$status=false)
    {
        $exam = Exam::findOne(['id'=>$exam_id]);
        $group_id = $exam->test_group;
        $jurusan = Yii::$app->user->identity->participant->study;
        $test_group = Yii::$app->params['test_group'];
        $test_group = $test_group[$group_id];
        $tools = $test_group['tools'];
        // if(file_exists($group_id.($jurusan?'-'.$jurusan:'').'.json') && $status==false)
        //     return json_decode(file_get_contents($group_id.'.json'));
        
        $categories = Category::find()
                    ->where([
                        'in', 'test_tool', $tools
                    ])
                    ->joinWith(['posts'=>function($q){
                        return $q->select(['id','post_title','post_content','jurusan']);
                    },'posts.items'=>function($q){
                        return $q->select(['id','post_title','post_content','jurusan']);
                    }])
                    ->asArray()
                    ->orderBy(['sequenced_number'=>'asc'])->all();
        $cats = [];
        foreach($categories as $cat)
        {
            $posts = [];
            foreach($cat['posts'] as $post)
            {
                if($cat['test_tool'] == 'IMJ' && $jurusan && $jurusan != $post['jurusan']) continue;
                if(isset($post['items']) && $cat['test_tool'] == 'TPA')
                    shuffle($post['items']);

                $posts[] = $post;
            }
            $cat['posts'] =  $posts;
            $cats[] = $cat;
        }
        // file_put_contents($group_id.($jurusan?'-'.$jurusan:'').'.json',json_encode($cats));
        return $cats;
    }
}