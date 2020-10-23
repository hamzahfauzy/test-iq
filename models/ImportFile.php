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
class ImportFile extends Model
{
    public $category_id;
    public $file;
    public $tipe;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['category_id', 'file','tipe'], 'required'],
        ];
    }
}
