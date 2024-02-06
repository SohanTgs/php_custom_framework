<?php

namespace App\Database\WhereQuery;

class BuildQuery{
    private $whereBuilder = [
        'or'=>OrWhere::class,
        'where'=>Where::class,
        'not'=>WhereNot::class,
        'or_not'=>OrWhereNot::class,
        'between'=>WhereBetween::class,
        'in'=>WhereIn::class,
        'not_in'=>WhereNotIn::class,
        'exists'=>WhereExists::class
    ];

    public function getQuery($query,$whereValue){
        $class = new $this->whereBuilder[$whereValue['type']];
        $buildedQuery = $class->buildQuery($query,$whereValue);
        return $buildedQuery;
    }
}