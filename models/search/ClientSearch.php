<?php

namespace app\models\search;

use app\models\Client;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "log".
 *
 * @property string $search
 * @property string $is_new
 */
class ClientSearch extends Client
{

    public $search;
    public $is_new;

    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['first_name', 'last_name', 'email', 'address', 'description', 'is_new', 'search'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Client::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if ($this->validate()) {
            $int_attrs = ['id'];
            $str_attrs = ['first_name', 'last_name', 'email', 'address', 'description'];

            // todo how to do
            if($this->is_new==='1'){
                $query->rightJoin('[order]', '[order].client_id <> client.id');
            }
            if($this->is_new==='0'){
                $query->rightJoin('[order]', '[order].client_id = client.id');
                // $query->join('[order]', '[order].client_id = client.id'); // no working
            }

            if(empty($this->search)){
                foreach ($int_attrs as $attr) {
                    $query->andFilterWhere([$attr => $this->$attr]);
                }
                foreach ($str_attrs as $attr){
                    $query->andFilterWhere(['like', $attr, $this->$attr]);
                }
            }
            else{
                foreach ($int_attrs as $attr) {
                    $query->orFilterWhere([$attr => intval($this->search)]);
                }
                foreach ($str_attrs as $attr){
                    $query->orFilterWhere(['like', $attr, $this->search]);
                }
            }
        }

        return $dataProvider;
    }
}
