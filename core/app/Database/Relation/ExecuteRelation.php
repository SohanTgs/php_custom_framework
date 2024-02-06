<?php

namespace App\Database\Relation;

trait ExecuteRelation{
    protected function belongsTo($model,$primaryKey,$foreignKey){
        $this->storeRelation($model,$primaryKey,$foreignKey,'belongsTo');
        return new $model;
    }

    protected function hasMany($model,$primaryKey,$foreignKey){
        $this->storeRelation($model,$primaryKey,$foreignKey,'hasMany');
        return new $model;
    }

    protected function hasOne($model,$primaryKey,$foreignKey){
        $this->storeRelation($model,$primaryKey,$foreignKey,'hasOne');
        return new $model;
    }

    private function storeRelation($model,$primaryKey,$foreignKey,$type){
        $relationName = $this->tempRelationName;
        $this->relations[$relationName] = [
            'type'=>$type,
            'model'=>$model,
            'primaryKey'=>$primaryKey,
            'foreignKey'=>$foreignKey
        ];
    }
    
}