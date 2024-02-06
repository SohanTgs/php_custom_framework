<?php

namespace App\Database\WhereQuery;

class WhereBuilder{

    private $query;

    public function build($where){
        foreach ($where as $whereValue) {
            $this->__where($whereValue);
        }
        return $this->query;
    }

    private function __where($whereValue){
        $builder = new BuildQuery;
        $this->query .= $builder->getQuery($this->query,$whereValue);
    }
}