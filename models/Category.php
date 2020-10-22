<?php

namespace app\models;

use Yii;

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
                ->viaTable('category_post',['category_id'=>'id'])->with(['items'=>function($q){
                    $q->select(['id','post_content']);
                }]);
    }
}
