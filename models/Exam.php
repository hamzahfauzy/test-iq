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
 * @property ExamAnswer[] $examAnswers
 * @property ExamParticipant[] $examParticipants
 * @property ExamQuestion[] $examQuestions
 */
class Exam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','test_group','start_time', 'end_time','group_id'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'test_group' => 'Test Group',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'created_at' => 'Created At',
        ];
    }
    
    public function groupName()
    {
        $group = $this->group();
        return $group['name'];
    }

    public function group()
    {
        return Yii::$app->params['test_group'][$this->test_group];
    }

    /**
     * Gets query for [[ExamAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamAnswers()
    {
        return $this->hasMany(ExamAnswer::className(), ['exam_id' => 'id']);
    }

    /**
     * Gets query for [[ExamParticipants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamParticipants()
    {
        return $this->hasMany(ExamParticipant::className(), ['exam_id' => 'id']);
    }

    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['id' => 'participant_id'])
                ->viaTable('exam_participants',['exam_id'=>'id']);
    }

    /**
     * Gets query for [[ExamQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamQuestions()
    {
        return $this->hasMany(ExamQuestion::className(), ['exam_id' => 'id']);
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}
