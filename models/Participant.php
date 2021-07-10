<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "participants".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $id_number
 * @property string|null $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $birthdate
 *
 * @property ExamAnswer[] $examAnswers
 * @property ExamParticipant[] $examParticipants
 * @property User $user
 */
class Participant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['id_number', 'name', 'birthdate'], 'required'],
            [['id_number'], 'unique'],
            [['address','id_number'], 'string'],
            [['birthdate','school','study','work_time','age'], 'safe'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'id_number' => 'Id Number',
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'birthdate' => 'Birthdate',
            'age' => 'Age',
            'school' => 'School',
            'study' => 'Study',
            'work_time' => 'Work Time',
        ];
    }

    /**
     * Gets query for [[ExamAnswers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamAnswers()
    {
        return $this->hasMany(ExamAnswer::className(), ['participant_id' => 'id']);
    }

    /**
     * Gets query for [[ExamParticipants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamParticipants()
    {
        return $this->hasMany(ExamParticipant::className(), ['participant_id' => 'id']);
    }

    public function getExamCategories()
    {
        return $this->hasMany(ExamCategory::className(), ['participant_id' => 'id'])->joinWith(['category']);
    }

    public function getExamParticipant()
    {
        return $this->hasOne(ExamParticipant::className(), ['participant_id' => 'id']);
    }

    public function getExam()
    {
        return $this->hasOne(Exam::className(), ['id' => 'exam_id'])->viaTable('exam_participants',['participant_id'=>'id'])->where(['>=','end_time',date("Y-m-d H:i:s")])->andWhere(['<=','start_time',date("Y-m-d H:i:s")]);
    }

    public function getFirstExam()
    {
        return $this->hasOne(Exam::className(), ['id' => 'exam_id'])->viaTable('exam_participants',['participant_id'=>'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getMeta($key = false)
    {
        $all_metas = UserMetas::find()->where(['user_id'=>$this->user_id])->all();
        if($key == false)
            return $all_metas;
        $all_metas = ArrayHelper::map($all_metas,'meta_key','meta_value');
        return isset($all_metas[$key]) ? $all_metas[$key] : '';
    }

    public function getAge()
    {
        if($this->birthdate || $this->getMeta('tanggal_lahir'))
        {
            $birthdate = $this->birthdate??$this->getMeta('tanggal_lahir');
            $date = new \DateTime($birthdate);
            $now = new \DateTime();
            $interval = $now->diff($date);
            return $interval->y;
        }

        return 0;
    }
}
