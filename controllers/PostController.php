<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostItems;
use app\models\PostItemsSearch;
use app\models\Category;
use app\models\CategoryPost;
use app\models\PostSearch;
use app\models\ImportFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['PostSearch']['not_post_as'] = "Jawaban";
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new PostItemsSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['PostItemsSearch']['parent_id'] = $id;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($as = '', $parent = 0)
    {
        $model = new Post();
        $model->post_as = $as;
        if($as == 'Jawaban')
            $model->post_title = "Jawaban";

        $category_post = new CategoryPost;

        if ($model->load(Yii::$app->request->post())){
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $model->save();
                if($parent)
                {
                    $_parent = Post::findOne($parent);
                    $model->link('parents',$_parent);
                }
                $category_post->post_id = $model->id;
                if($category_post->load(Yii::$app->request->post()))
                    $category_post->save();
                
                $transaction->commit();
            } catch (\Throwable $th) {
                //throw $th;
                $transaction->rollback();
            }
            return $this->redirect(['view', 'id' => $parent ? $parent : $model->id]);
        }

        $categories = Category::find()->all();
        $categories = ArrayHelper::map($categories,'id','name');

        return $this->render('create', [
            'model' => $model,
            'category_post' => $category_post,
            'categories' => $categories,
        ]);
    }

    public function actionImports()
    {
        $model = new ImportFile;
        
        if ($model->load(Yii::$app->request->post())){
            $uploadedFile = \yii\web\UploadedFile::getInstances($model,'file');
            if($model->tipe == 'questions')
            {
                $uploadedFile = $uploadedFile[0];
                $extension    = $uploadedFile->extension;
                if($extension=='xlsx'){
                    $inputFileType = 'Xlsx';
                }else{
                    $inputFileType = 'Xls';
                }
                $reader     = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                 
                $spreadsheet = $reader->load($uploadedFile->tempName);
                $worksheet   = $spreadsheet->getActiveSheet();
                $highestRow  = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                 
                //inilah looping untuk membaca cell dalam file excel,perkolom
                  
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $category = Category::findOne($model->category_id);
                    for ($row = 2; $row <= $highestRow; $row++) { //$row = 2 artinya baris kedua yang dibaca dulu(header kolom diskip disesuaikan saja)
                        $no = $row-1;
                        // create post (soal)
                        $post = new Post;
                        $post->post_title = "Soal ".$category->name." ".$no;
                        $post->post_as    = "Soal";
                        $post->save(false);
                        
                        // assign category to post (soal)
                        $category_post = new CategoryPost;
                        $category_post->category_id = $model->category_id;
                        $category_post->post_id = $post->id;
                        $category_post->save();
    
                        if($category->sequenced_number == 4) // for CFIT subtest 2
                        {
                            // save true answer
                            $child = new Post;
                            $child->post_title = "Jawaban ".$category->name." ".$no;
                            $child->post_content = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                            $child->post_as = "Jawaban";
                            $child->post_type = "1";
                            $child->save(false);
                            $child->link('parents',$post);
                        }
                        elseif(in_array($category->sequenced_number,[10,11,12])) // for Papicostick
                        {
                            // save A
                            $child = new Post;
                            $child->post_title = "Jawaban A ".$category->name." ".$no;
                            $child->post_content = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                            $child->post_as = "Jawaban";
                            $child->post_type = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                            $child->save(false);
                            $child->link('parents',$post);
    
                            // save B
                            $child = new Post;
                            $child->post_title = "Jawaban B ".$category->name." ".$no;
                            $child->post_content = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                            $child->post_as = "Jawaban";
                            $child->post_type = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                            $child->save(false);
                            $child->link('parents',$post);
                        }
                        // elseif($category->sequenced_number == 12) // for MSDT
                        // {
                        //     // Save A
                        //     $child = new Post;
                        //     $child->post_title = "Jawaban A ".$category->name." ".$no;
                        //     $child->post_content = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        //     $child->post_as = "Jawaban";
                        //     $child->post_type = "A";
                        //     $child->save(false);
                        //     $child->link('parents',$post);
    
                        //     // Save B
                        //     $child = new Post;
                        //     $child->post_title = "Jawaban B ".$category->name." ".$no;
                        //     $child->post_content = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        //     $child->post_as = "Jawaban";
                        //     $child->post_type = "B";
                        //     $child->save(false);
                        //     $child->link('parents',$post);
                        // }
                        else
                        {
                            $alphabet = range('a', 'z');
                            $num = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                            $index = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                            for($i=0;$i<$num;$i++)
                            {
                                $child = new Post;
                                $child->post_title = "Jawaban ".$alphabet[$i]." ".$category->name." ".$no;
                                $child->post_content = $alphabet[$i];
                                $child->post_as = "Jawaban";
                                $child->post_type = $index == $alphabet[$i] ? 1 : 0;
                                $child->save(false);
                                $child->link('parents',$post);
                            }
                        }
                        //for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                        // echo $worksheet->getCellByColumnAndRow(1, $row)->getValue(); //3 artinya kolom ke3
                        // $kolom10 = $worksheet->getCellByColumnAndRow(10, $row)->getValue(); // 10 artinya kolom 10
                    }
                    $transaction->commit();
                    Yii::$app->session->addFlash("success", "Import Posts Success");
                } catch (\Throwable $th) {
                    throw $th;
                    $transaction->rollback();
                }
            }
            else
            {
                $serial_names = [
                    'SUB 1' => 'Soal CFIT 1',
                    'SUB 2' => 'Soal CFIT 2',
                    'SUB 3' => 'Soal CFIT 3',
                    'SUB 4' => 'Soal CFIT 4',
                ];

                foreach($uploadedFile as $file)
                {
                    $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                    $name = $file->baseName;
                    // get serial name
                    $name = explode('-',$name);
                    $number = $name[1];
                    $name = $name[0];
                    $title = $serial_names[$name].' '.$number;
                    $soal = Post::find()->where(['post_title'=>$title])->one();
                    $soal->post_content .= '<p><img alt="" src="'.Url::to(['uploads/'.$file->baseName . '.' . $file->extension],true).'" width="100%" /></p>';
                    $soal->save(false);
                }
                Yii::$app->session->addFlash("success", "Import 2 Posts Success");
            }
            return $this->redirect(['imports']);
        }

        $categories = Category::find()->orderby(['sequenced_number'=>SORT_ASC])->all();
        $categories = ArrayHelper::map($categories,'id','name');

        return $this->render('imports', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category_post = $model->categoryPosts ? $model->getCategoryPosts()->one() : new CategoryPost;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(in_array($model->post_as,['Soal','Instruksi']))
            {
                if(!$category_post->post_id)
                    $category_post->post_id = $model->id;
                if($category_post->load(Yii::$app->request->post()))
                    $category_post->save();
            }
            return $this->redirect(['view', 'id' => in_array($model->post_as,['Soal','Instruksi']) ? $model->id : $model->parent->id]);
        }

        $categories = Category::find()->all();
        $categories = ArrayHelper::map($categories,'id','name');

        return $this->render('update', [
            'model' => $model,
            'category_post' => $category_post,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $redirect = ['index'];
        if($model->parent)
            $redirect = ['view','id'=>$model->parent->id];
        $model->delete();

        return $this->redirect($redirect);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
