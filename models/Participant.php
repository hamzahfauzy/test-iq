<?php

namespace app\models;

use Yii;

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
            [['user_id', 'id_number'], 'integer'],
            [['id_number', 'name', 'address', 'birthdate'], 'required'],
            [['id_number'], 'unique'],
            [['address'], 'string'],
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
