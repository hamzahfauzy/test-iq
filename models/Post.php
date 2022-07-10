<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string|null $post_title
 * @property string|null $post_content
 * @property string|null $post_as
 * @property string|null $post_type
 * @property string $post_date
 *
 * @property CategoryPost[] $categoryPosts
 * @property ExamAnswer[] $examAnswers
 * @property ExamAnswer[] $examAnswers0
 * @property ExamQuestion[] $examQuestions
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_content'], 'string'],
            [['post_date','jurusan'], 'safe'],
            [['post_title', 'post_as', 'post_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_title' => 'Post Title',
            'post_content' => 'Post Content',
            'post_as' => 'Post As',
            'post_type' => 'Post Type',
            'post_date' => 'Post Date',
            'jurusan' => 'Jurusan',
        ];
    }

    /**
     * Gets query for [[CategoryPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPosts()
    {
        return $this->hasMany(CategoryPost::className(), ['post_id' => 'id']);
    }
    
    public function getCategoryPost()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])
        ->viaTable('category_post',['post_id' => 'id']);
    }

    /**
     * Gets query for [[ExamAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamAnswers()
    {
        return $this->hasMany(ExamAnswer::className(), ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[ExamAnswers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamAnswers0()
    {
        return $this->hasMany(ExamAnswer::className(), ['question_id' => 'id']);
    }

    /**
     * Gets query for [[ExamQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamQuestions()
    {
        return $this->hasMany(ExamQuestion::className(), ['post_id' => 'id']);
    }

    public function getParents()
    {
        return $this->hasMany(Post::className(), ['id' => 'parent_id'])
          ->viaTable('post_items', ['child_id' => 'id']);
    }

    public function getItems()
    {
        return $this->hasMany(Post::className(), ['id' => 'child_id'])
          ->viaTable('post_items', ['parent_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Post::className(), ['id' => 'parent_id'])
          ->viaTable('post_items', ['child_id' => 'id']);
    }

    public function getPostItem()
    {
        return $this->hasOne(PostItems::className(),['child_id' => 'id']);
    }
}
