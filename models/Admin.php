<?php

namespace app\models;

use Jose\Factory\JWKFactory;
use Jose\Loader;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;


class Admin extends AbstractAdmin implements \yii\web\IdentityInterface
{
    public $name = 'admin';
    public $token;

    public static function findByUserLogin($login)
    {
        return Admin::findOne(['login' => $login]);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        // No need
    }

    /**
     * @param string $token
     * @return IdentityInterface|null
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return (static::findOne(['id' => 1]));


        // $jwk = JWKFactory::createFromKey(file_get_contents(__DIR__ . '/../private_key/private.key'), 'secret', ['use' => 'sig', 'alg' => 'RS256']);

        $jwk = JWKFactory::createFromKeyFile(
            '/data/private_key/private.key',
            'Password',
            [
                'kid' => 'My Private RSA key',
                'alg' => 'RS256',
                'use' => 'sig',
            ]
        );

        // The payload is decrypted using our key.
        $jws = (new Loader())->loadAndVerifySignatureUsingKey(
            $token,            // The input to load and decrypt
            $jwk,              // The symmetric or private key
            ['RS256']
        );

        // var_dump($jws->getPayload());
        /** @var array $data */
        $data = $jws->getPayload();
        $userId = $data['sub'];

        $identity = static::findOne(['id' => $userId]);
        \Yii::$app->user->login($identity);

        return $identity;

        /*$user = static::findOne(['access_token' => $token]);

        if (!$user) {
            return null;
        }
        if ($user->expire_at < time()) {
            throw new UnauthorizedHttpException('the access - token expired ', -1);
        } else {
            return $user;
        }*/
    }

    public function createUser($params){
        $this->load($params, '');

        if ($this->validate()) {
            $this->setPassword($this->password);
            $this->save(false);
        }
        return $this;

        // another way to do this in detail
//        if($this->validate()){
//            $this->setPassword($this->password);
//            $this->save(false);
//            return $this->attributes;
//        }
//        \Yii::$app->response->setStatusCode(422, 'params no ok');
//        return $this->errors;
    }
    public function setPassword(string $password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    public function search($params)
    {
        $query = Admin::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->where(['<>','id', \Yii::$app->user->getId()]);
        $this->load($params);
        /*if (!$this->validate()) {
            return $dataProvider;
        }*/
        $request = Yii::$app->request;
        if ($request->get('search_q') === null) {
            return $dataProvider;
        }

        $query->orFilterWhere(['like', 'name', $request->get('search_q')])
            ->orFilterWhere(['like', 'email', $request->get('search_q')])
            ->orFilterWhere([
                'id' => intval($request->get('search_q')), // I can not do this because it's not interger omfg
            ]);
        return $dataProvider;
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'token'
        ];
    }

    public function extraFields()
    {
        return [
            "email",
            "group" => function ($model) {
                return $model->groups;
            }
        ];
    }

    public function validatePassword(string $password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        // No need
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        // No need
    }

    /**
     * generate accessToken
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
        return $this->access_token;
    }
}
