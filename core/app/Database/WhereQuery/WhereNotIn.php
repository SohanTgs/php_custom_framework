<?php

namespace App\Database\WhereQuery;

class WhereNotIn {
    public function buildQuery($query,$whereValue){
        $column = $whereValue['column'];
        $value = $whereValue['value'];

        $info = $value;
        $value = '';
        foreach($info as $inf){
            $value .= sprintf("'%s'",$inf).',';
        }
        $value = rtrim($value,',');
        $value = "($value)";

        if (!$query) {
            $query = sprintf("WHERE `%s` NOT IN %s", $column, $value);
        }else{
            $query = sprintf(" AND `%s` NOT IN %s", $column, $value);
        }
        return $query;
    }
}