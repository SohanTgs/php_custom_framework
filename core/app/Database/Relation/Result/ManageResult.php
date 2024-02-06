<?php

namespace Ovolab\BackOffice\Database\Relation\Result;

class ManageResult {

    private $relations;
    private $data;

    private $relationClasses = [
        'belongsTo'=>BelongsTo::class,
        'hasMany'=>HasMany::class,
        'hasOne'=>HasOne::class
    ];

    public function __construct($relations,$data){
        $this->relations = $relations;
        $this->data = $data;
    }

    public function manage(){
        $relations = $this->relations;
        foreach ($relations as $key => $relation) {
            $relation = ovolab_to_object($relation);
            if($relation->query_type == 'data'){
                $this->data = (new $this->relationClasses[$relation->type])->getResult($this->data,$relation,$key);
            }
        }
        return $this->data;
    }
}