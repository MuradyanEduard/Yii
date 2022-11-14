<?php

namespace tests\unit\models;

use app\models\UserOld;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = UserOld::findIdentity(100))->notEmpty();
        verify($user->login)->equals('admin');

        verify(UserOld::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = UserOld::findIdentityByAccessToken('100-token'))->notEmpty();
        verify($user->login)->equals('admin');

        verify(UserOld::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = UserOld::findByLogin('admin'))->notEmpty();
        verify(UserOld::findByLogin('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = UserOld::findByLogin('admin');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();        
    }

}
