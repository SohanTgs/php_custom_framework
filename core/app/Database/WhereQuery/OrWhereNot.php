<?php

namespace App\Database\WhereQuery;

class OrWhere {
    public function buildQuery($query,$whereValue){
        $column = $whereValue['column'];
        $symbol = $whereValue['symbol'];
        $value = $whereValue['value'];
        if (!$query) {
            throw new \Exception("You need to add a where first");
        }else{
            $query = sprintf(" OR NOT `%s` $symbol '%s'", $column, $value);
        }
        return $query;
    }
}