<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
{
    public $login;
    public $password;
    public $email;
    public $role;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // login and password are both required
            [['login', 'password','email','role'], 'required'],
            // rememberMe must be a boolean value
            [['email'],'email']
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $model = new SignupForm;
        $model->load(Yii::$app->request->post());

        $author = new Author();
        $author->name = $model->login;
        $author->booksArr = [''];
        $author->save();

        $user = new User();
        $user->login = $model->login;
        $user->password = $model->password;
        $user->email = $model->email;
        $user->role = $model->role;
        $user->author_id = $author->id;
        $user->authkey = Yii::$app->security->generateRandomString();
        $user->accessToken = Yii::$app->security->generateRandomString();

        return $user->save();
    }
}
