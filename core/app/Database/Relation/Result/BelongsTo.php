<?php

namespace Ovolab\BackOffice\Database\Relation\Result;

class BelongsTo extends ResultProcessor {

    protected function getKeyValues($data,$relation){
        $foreignKey = $relation->foreignKey;
        return array_unique(array_map(function($item) use ($foreignKey) {
            return $item->$foreignKey;
        }, $data));
    }

    protected function getSql($keyValues,$relation,$relationalQuery){
        if (!empty($keyValues)) {
            return @$relationalQuery->whereIn($relation->primaryKey,$keyValues)->getQuery();
        }
    }

    protected function getFilteredData($primaryKey,$foreignKey,$item,$result){
        foreach($result as $resultData){
            if (@$resultData->$primaryKey == @$item->$foreignKey) {
                return $resultData;
            }else{
                continue;
            }
        }
        return null;
    }
}