<?php

namespace app\models\search;

use app\models\Order;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "log".
 *
 * @property string $search
 * @property string $start_date
 * @property string $period
 * @property string $duration
 */
class OrderSearch extends Order
{

    public $search;
    public $start_date;
    public $period;
    public $duration;

    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'client_id'], 'integer'],
            [['ref', 'description', 'search', 'start_date', 'period', 'duration'], 'safe'],
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
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if ($this->validate()) {
            $attrs = ['id', 'status', 'client_id'];
            $like_attrs = ['ref', 'description'];

            if(!empty($this->start_date)&&!empty($this->period)&&!empty($this->duration)){
                //ex start_date = 2020-03-12;  period = day; duration = 2
                $startDate = strtotime($this->start_date);
                $endDate = strtotime($this->start_date . "+{$this->duration} {$this->period}");
                $query->andFilterCompare('created_at', ">=$startDate");
                $query->andFilterCompare('created_at', "<=$endDate");
            }

            if(empty($this->search)){
                foreach ($attrs as $attr) {
                    $query->andFilterWhere([$attr => $this->$attr]);
                }
                foreach ($like_attrs as $attr){
                    $query->andFilterWhere(['like', $attr, $this->$attr]);
                }
            }
            else{
                foreach ($attrs as $attr) {
                    $query->orFilterWhere([$attr => intval($this->search)]);
                }
                foreach ($like_attrs as $attr){
                    $query->orFilterWhere(['like', $attr, $this->search]);
                }
            }
        }

        return $dataProvider;
    }
}
