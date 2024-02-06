<?php

namespace App\Database;

trait GetQuery{

    use GetRows, GetOnlyNumbers;

    private function query(){
        return sprintf('%s FROM {{table_prefix}}%s %s',$this->withQuery, $this->table,$this->query);
    }

    protected function getQuery($isReturn = false){
        $this->buildQuery();
        $query = sprintf('SELECT * '.$this->query());
        if ($isReturn) {
            return $query;
        }
        $this->data = $query;
    }

    protected function getCondition(){
        $this->buildQuery();
        return $this->query;
    }
}