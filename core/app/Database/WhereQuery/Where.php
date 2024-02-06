<?php

namespace App\Database\WhereQuery;

class Where {
    public function buildQuery($query,$whereValue){
        $column = $whereValue['column'];
        $symbol = $whereValue['symbol'];
        $value = $whereValue['value'];
        if (!$query) {
            $query = sprintf("WHERE `%s` $symbol '%s'", $column, $value);
        }else{
            $query = sprintf(" AND `%s` $symbol '%s'", $column, $value);
        }
        return $query;
    }
}