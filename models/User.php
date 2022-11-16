<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $login
 * @property string|null $password
 * @property int|null $role
 * @property int|null $author_id
 * @property string|null $authkey
 * @property string|null $accessToken
 *
 * @property Author $author
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ADMIN_ROLE = 0;
    const USER_ROLE = 1;
    const CUSTOMER_ROLE = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'author_id'], 'integer'],
            [['email', 'login', 'password', 'authkey', 'accessToken'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
            [['email', 'login', 'password'], 'required'],
            [['email'],'email'],
            [['login'],'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'login' => 'Login',
            'password' => 'Password',
            'role' => 'Role',
            'author_id' => 'Author ID',
            'authkey' => 'Authkey',
            'accessToken' => 'Access Token',
        ];
    }


    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authkey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authkey===$authKey;
    }

    public function validatePassword($password)
    {
        return ($this->password == $password)?true:false;
    }

    public static function findByLogin($login)
    {
        return User::find()->where(['login' => $login])->one();
    }
}
