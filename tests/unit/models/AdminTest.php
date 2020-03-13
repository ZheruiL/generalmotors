<?php

namespace tests\unit\models;

use app\models\Admin;

class AdminTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = Admin::findIdentity(100));
        expect($user->username)->equals('admin');

        expect_not(Admin::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = Admin::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(Admin::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = Admin::findByUsername('admin'));
        expect_not(Admin::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = Admin::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    }

}
