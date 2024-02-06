<?php

namespace App\Database\WhereQuery;

class WhereIn {
    public function buildQuery($query,$whereValue){
        $column = $whereValue['column'];
        $value = $whereValue['value'];
        if (empty($value)) {
            $value = [];
        }
        
        $info = $value;
        $value = '';
        foreach($info as $inf){
            $value .= sprintf("'%s'",$inf).',';
        }
        $value = rtrim($value,',');
        $value = "($value)";
        if (!$query) {
            $query = sprintf("WHERE `%s` IN %s", $column, $value);
        }else{
            $query = sprintf(" AND `%s` IN %s", $column, $value);
        }
        return $query;
    }
}