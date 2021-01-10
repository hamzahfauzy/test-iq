<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exam_answers".
 *
 * @property int $id
 * @property int|null $exam_id
 * @property int|null $question_id
 * @property int|null $answer_id
 * @property int|null $score
 * @property int|null $participant_id
 * @property string $created_at
 *
 * @property Post $answer
 * @property Exam $exam
 * @property Participant $participant
 * @property Post $question
 */
class ExamAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam_answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam_id', 'question_id', 'answer_id', 'participant_id'], 'integer'],
            [['created_at','answer_content'], 'safe'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['answer_id' => 'id']],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exam::className(), 'targetAttribute' => ['exam_id' => 'id']],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exam_id' => 'Exam ID',
            'question_id' => 'Question ID',
            'answer_id' => 'Answer ID',
            'answer_content' => 'Answer Content',
            'score' => 'Score',
            'participant_id' => 'Participant ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Answer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Post::className(), ['id' => 'answer_id']);
    }

    /**
     * Gets query for [[Exam]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExam()
    {
        return $this->hasOne(Exam::className(), ['id' => 'exam_id']);
    }

    /**
     * Gets query for [[Participant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }

    /**
     * Gets query for [[Question]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Post::className(), ['id' => 'question_id']);
    }
}
