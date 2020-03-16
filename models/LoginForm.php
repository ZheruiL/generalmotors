<?php

namespace app\models;

use Jose\Factory\JWKFactory;
use Jose\Factory\JWSFactory;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property Admin|null $_user This property is read-only.
 *
 */
class LoginForm extends Model
{
    const EXPIRE_TIME = 6000; //6000 seconds
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // login and password are both required
            [['login', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->{$attribute})) {
                $this->addError($attribute, 'Incorrect login or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided login and password.
     * @return bool whether the user is logged in successfully
     */
    /*public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }*/
    /**
     * Finds user by [[login]]
     *
     * @return Admin|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Admin::findByUserLogin($this->login);
        }

        return $this->_user;
    }
    /*
    public function login()
    {
        if ($this->validate()) {
            $access_token=$this->_user->generateAccessToken();
            $this->_user->save();
            return $access_token;
        } else {
            return false;
        }
    }*/


    public function login()
    {
        if ($this->validate()) {
            // We load our key (JWK). It is an encrypted RSA key stored in a file
            // Additional parameters ('kid', 'alg' and 'use') are set for this key (not mandatory but recommended).
            $key = JWKFactory::createFromKeyFile(
                '/data/private_key/private.key',
                'Password',
                [
                    'kid' => 'My Private RSA key',
                    'alg' => 'RS256',
                    'use' => 'sig',
                ]
            );

            // We want to sign the following claims
            $claims = [
                'nbf'     => time(),        // Not before
                'iat'     => time(),        // Issued at
                'exp'     => time() + 3600, // Expires at
                'iss'     => 'todolist',          // Issuer
                'aud'     => 'You',         // Audience
                'sub'     => $this->_user->id,   // Subject
                'is_root' => true           // Custom claim
            ];

            $jws = JWSFactory::createJWSToCompactJSON(
                $claims,                      // The payload or claims to sign
                $key,                         // The key used to sign
                [                             // Protected headers. Muse contains at least the algorithm
                    'crit' => ['exp', 'aud'],
                    'alg'  => 'RS256',
                ]
            );
            return $jws;


            $this->_user->save();
            Yii::$app->user->login($this->_user, static::EXPIRE_TIME);
            return $access_token;
        }
        return false;
    }
}
