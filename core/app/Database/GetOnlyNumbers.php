<?php

namespace App\Database;

use App\Facade\DB;

trait GetOnlyNumbers{
    protected function count(){
        $this->buildQuery();
        $finalQuery = sprintf('SELECT COUNT(*) '.$this->query());
        $result = DB::getVar($finalQuery);
        $result = $result ?? 0;
        $this->data = (int)$result;
    }

    protected function avg($column){
        $this->buildQuery();
        $finalQuery = sprintf('SELECT AVG(`%s`) '.$this->query(), $column);
        $result = DB::getVar($finalQuery);
        $this->data = (int)$result;
    }

    protected function sum($column){
        $this->buildQuery();
        $finalQuery = sprintf('SELECT SUM(`%s`) '.$this->query(), $column);
        $result = DB::getVar($finalQuery);
        $this->data = (int)$result;
    }

    protected function min($column){
        $this->buildQuery();
        $finalQuery = sprintf('SELECT MIN(`%s`) '.$this->query(), $column);
        $result = DB::getVar($finalQuery);
        $result = $result ?? 0;
        $this->data = (int)$result;
    }

    protected function max($column){
        $this->buildQuery();

        $finalQuery = sprintf('SELECT MAX(`%s`) '.$this->query(), $column);
        $result = DB::getVar($finalQuery);
        $this->data = (int)$result;
    }
}