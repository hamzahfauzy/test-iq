<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ImportParticipant extends Model
{
    public $file, $exam_id;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['exam_id','file'], 'required'],
        ];
    }
}
