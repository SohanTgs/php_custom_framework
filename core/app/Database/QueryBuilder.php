<?php

namespace App\Database;

use App\Database\WhereQuery\WhereBuilder;

trait QueryBuilder {

    use GetQuery;
    // use SetQuery;

    private $query = '';

    private $withQuery = '';

    private function buildQuery(){
        $this->makeWhere();
        $this->makeWhereHasQuery();
        $this->makeWithQuery();
        $this->makeOrderBy();
        $this->makeLimit();
        $this->makeSkip();
    }

    private function makeWhere(){
        $this->query .= (new WhereBuilder)->build($this->where);
    }

    private function makeLimit(){
        if($this->limit){
            if (!$this->query) {
                $this->query .= 'LIMIT ' . $this->limit.' ';
            }else{
                $this->query .= ' LIMIT ' . $this->limit.' ';
            }
        }
    }

    private function makeSkip(){
        if($this->skip){
            if (!$this->query) {
                $this->query .= 'OFFSET ' . $this->skip.' ';
            }else{
                $this->query .= ' OFFSET ' . $this->skip.' ';
            }
        }
    }

    private function makeOrderBy(){
        $order = '';
        foreach($this->orderBy as $orderBy){
            if (!$order) {
                $order = sprintf('ORDER BY %s %s', '{{table_prefix}}'.$this->table.'.'.$orderBy['column'], $orderBy['order']);
            }else{
                $order .= sprintf(', %s %s', '{{table_prefix}}'.$this->table.'.'.$orderBy['column'], $orderBy['order']);
            }
        }
        if (!$this->query) {
            $this->query .= $order;
        }else{
            $this->query .= ' ' . $order;
        }
    }

    private function makeWhereHasQuery(){
        $query = $this->query;
        $relQueries = $this->relationalQuery;
        foreach ($relQueries as $key => $relQuery) {
            if (!$query) {
                $query = "WHERE $relQuery";
            }else{
                $query = " AND $relQuery";
            }
            $this->query .= $query;
        }
    }

    private function makeWithQuery(){
        $withQuery = $this->withRelation;
        foreach ($withQuery as $key => $relQuery) {
            $this->withQuery .= ", $relQuery";
        }
    }
}