<?php
namespace app\models\search;

class SearchQuery{
    public static function search($obj, $query, $int_attrs=null, $str_attrs=null){
        if(empty($obj->search)){
            foreach ($int_attrs as $attr) {
                $query->andFilterWhere([$attr => $obj->$attr]);
            }
            foreach ($str_attrs as $attr){
                $query->andFilterWhere(['like', $attr, $obj->$attr]);
            }
        }
        else{
            foreach ($int_attrs as $attr) {
                $query->orFilterWhere([$attr => intval($obj->search)]);
            }
            foreach ($str_attrs as $attr){
                $query->orFilterWhere(['like', $attr, $obj->search]);
            }
        }
    }

}