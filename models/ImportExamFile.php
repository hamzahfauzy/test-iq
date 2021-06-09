<?php

namespace app\models;

use Yii;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ImportExamFile extends \yii\db\ActiveRecord
{
    // public $file_path, $exam_id;
    // public $file_url;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'import_exam_files';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['exam_id'], 'required'],
            [['file_path'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx']
        ];
    }

    public function getExam()
    {
        return $this->hasOne(Exam::className(),['id'=>'exam_id']);
    }

    public function upload($instance)
    {
        if ($this->validate()) {
            $path = 'uploads/' . $instance->baseName . '.' . $instance->extension;
            $instance->saveAs($path);
            return $path;
        } else {
            return false;
        }
    }
}
