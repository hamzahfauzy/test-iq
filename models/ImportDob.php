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
class ImportDob extends Model
{
    public $file,$mode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file','mode'], 'required'],
        ];
    }
}
