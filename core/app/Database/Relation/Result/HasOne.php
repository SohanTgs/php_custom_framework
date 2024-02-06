<?php

namespace Ovolab\BackOffice\Database\Relation\Result;

class HasOne extends ResultProcessor{

    protected function getKeyValues($data,$relation){
        $primaryKey = $relation->primaryKey;
        return array_unique(array_map(function($item) use ($primaryKey) {
            return $item->$primaryKey;
        }, $data));
    }

    protected function getSql($keyValues,$relation,$relationalQuery){
        if (!empty($keyValues)) {
            return @$relationalQuery->whereIn($relation->foreignKey,$keyValues)->getQuery();
        }
    }

    protected function getFilteredData($primaryKey,$foreignKey,$item,$result){
        foreach($result as $resultData){
            if ($resultData->$foreignKey == $item->$primaryKey) {
                return $resultData;
            }else{
                continue;
            }
        }
        return null;
    }

}