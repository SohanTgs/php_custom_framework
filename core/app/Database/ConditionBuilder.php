<?php

namespace App\Database;

trait ConditionBuilder
{
    protected function where($column,$symOrVal,$value = null){
        if ($value) {
            $symbol = $symOrVal;
        }else{
            $symbol = '=';
            $value = $symOrVal;
        }
        $this->where[] = $this->__where($column,$symbol,$value,'where');
        return $this;
    }

    protected function orWhere($column,$symOrVal,$value = null){
        if ($value) {
            $symbol = $symOrVal;
        }else{
            $symbol = '=';
            $value = $symOrVal;
        }
        $this->where[] = $this->__where($column,$symbol,$value,'or');
        return $this;
    }

    protected function whereIn($column,array $value){
        $this->where[] = $this->__where($column,'=',$value,'in');
        return $this;
    }

    protected function whereNotIn($column, array $value){
        $this->where[] = $this->__where($column,'=',$value,'not_in');
        return $this;
    }

    protected function whereBetween($column, array $value){
        $this->where[] = $this->__where($column,'=',$value,'between');
        return $this;
    }

    protected function whereNot($column, $value){
        $this->where[] = $this->__where($column,'=',$value,'not');
        return $this;
    }

    protected function exists($column, $value){
        $this->where[] = $this->__where($column,'=',$value,'exists');
        return $this;
    }

    protected function orWhereNot($column, $value){
        $this->where[] = $this->__where($column,'=',$value,'or_not');
        return $this;
    }

    protected function limit(int $number){
        $this->limit = $number;
        return $this;
    }

    protected function skip(int $number){
        $this->skip = $number;
        return $this;
    }

    protected function orderBy($column,$order = 'asc'){
        $this->orderBy[] = [
            'column'=>$column,
            'order'=>$order
        ];
        return $this;
    }

    private function __where($column,$symbol,$value,$type){
        return [
            'column'=>$column,
            'symbol'=>$symbol,
            'value'=>$value,
            'type'=>$type
        ];
    }
}