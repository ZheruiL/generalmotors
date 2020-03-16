<?php

namespace app\models\search;

use app\models\Vehicle;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "log".
 *
 * @property string $search
 * @property int $make_id
 * @property int $energy_id
 */
class VehicleSearch extends Vehicle
{

    public $search;
    public $make_id;
    public $energy_id;

    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            /*[['id', 'model_id', 'energy_id', 'make_id', 'year', 'stock'], 'integer'],
            [['description', 'search'], 'safe'],*/
            [['model_id', 'energy_id', 'make_id', 'year', 'stock'], 'integer'],
            [['search'], 'safe']
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
        $query = Vehicle::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if($this->validate()){
            $joins= [
                ['model', 'model.id = vehicle.model_id'],
                ['make', 'make.id = model.make_id'],
                ['energy e', 'e.id = vehicle.energy_id']
            ];
            foreach ($joins as $join) {
                $query->leftJoin($join[0], $join[1]);
            }

            $int_attrs = [
                'vehicle.model_id', 'vehicle.energy_id', 'model.make_id', 'vehicle.year', 'vehicle.energy_id'
            ];
            $str_attrs = [
                'vehicle.description', 'model.name', 'make.name', 'e.name'
            ];
            if(empty($this->search)){
                // search by model_id, energy_id, make_id and year
                foreach ($int_attrs as $attr) {
                    $attrId = substr($attr, strpos($attr, '.')+1);
                    $query->andFilterWhere([$attr => $this->$attrId]);
                }
            }
            else{
                // general search for all columns
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
