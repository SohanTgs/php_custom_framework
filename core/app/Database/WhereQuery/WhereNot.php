<?php

namespace App\Database\WhereQuery;

class WhereNot {
    public function buildQuery($query,$whereValue){
        $column = $whereValue['column'];
        $symbol = $whereValue['symbol'];
        $value = $whereValue['value'];
        if (!$query) {
            $query = sprintf("WHERE NOT `%s` $symbol '%s'", $column, $value);
        }else{
            $query = sprintf(" AND NOT `%s` $symbol '%s'", $column, $value);
        }
        return $query;
    }
}