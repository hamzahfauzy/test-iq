<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exams".
 *
 * @property int $id
 * @property string|null $name
 * @property string $start_time
 * @property string $end_time
 * @property string $created_at
 *
 */
class GroupItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id','group_id','sequenced_number'], 'required'],
            [['category_id','group_id','sequenced_number'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'group_id' => 'Group',
            'sequenced_number' => 'Sequenced Number'
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasMany(Group::className(), ['id' => 'group_id']);
    }
    
    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
