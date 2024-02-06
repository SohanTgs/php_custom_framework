<?php

namespace App\Database\WhereQuery;

class WhereBetween {
    public function buildQuery($query,$whereValue){
        $column = $whereValue['column'];
        $value = $whereValue['value'];
        if (!$query) {
            $query = sprintf("WHERE `%s` BETWEEN '%s' AND '%s'", $column, $value[0], $value[1]);
        }else{
            $query = sprintf(" AND `%s` BETWEEN '%s' AND '%s'", $column, $value[0], $value[1]);
        }
        return $query;
    }
}