<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sequenced_number
 * @property int|null $has_timer
 *
 * @property CategoryPost[] $categoryPosts
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sequenced_number'], 'integer'],
            [['name','test_tool','sequenced_number','has_timer'], 'required'],
            [['name','has_timer','countdown'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sequenced_number' => 'Sequenced Number',
            'has_timer' => 'Has Timer',
            'countdown' => 'Countdown',
            'test_tool' => 'Test Tool',
        ];
    }

    /**
     * Gets query for [[CategoryPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPosts()
    {
        return $this->hasMany(CategoryPost::className(), ['category_id' => 'id']);
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(),['id'=>'post_id'])
                ->viaTable('category_post',['category_id'=>'id'])->with(['items'=>function($q) {
                    $q->select(['id','post_content']);
                }]);
    }

    public function getQuestions()
    {
        return $this->hasMany(Post::className(),['id'=>'post_id'])
                ->viaTable('category_post',['category_id'=>'id'])->with(['items']);
    }

    public function getDemoPosts()
    {
        return $this->hasMany(Post::className(),['id'=>'post_id'])
                ->viaTable('category_post',['category_id'=>'id'])->with(['items'=>function($q){
                    $q->select(['id','post_content']);
                }]);
    }

    public function getDemoPost()
    {
        return $this->hasOne(Post::className(),['id'=>'post_id'])
                ->viaTable('category_post',['category_id'=>'id'])->with(['items'=>function($q){
                    $q->select(['id','post_content']);
                }]);
    }

    public function sequenced_number($group_id)
    {
        $model = GroupItem::find()->where([
            'group_id'=>$group_id,
            'category_id'=>$this->id
        ]);

        if($model->exists())
        {
            return $model->one()->sequenced_number;
        }

        return 0;
    }
}
