<?php

namespace App\Database;

use App\Facade\DB;

trait SetQuery{

    protected function insert($data){
        $table = $this->table;
        $fields = '';
        $values = '';

        foreach ($data as $col => $value) {
            $fields .= sprintf('`%s`,', $col);
            $values .= sprintf("'%s',", $value);
        }

        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);

        $sql = sprintf('INSERT INTO {{table_prefix}}%s (%s) VALUES (%s)', $table, $fields, $values);
        DB::query($sql);
        $sql = sprintf("SELECT * FROM {{table_prefix}}%s WHERE `id` = LAST_INSERT_ID();",$table);
        $this->data = DB::getRow($sql);
    }

    protected function update($data){
        $this->buildQuery();
        $query = '  '.$this->query;

        $table = $this->table;

        $update = '';

        foreach ($data as $col => $value) {
            $update .= sprintf("`%s`='%s', ", $col, $value);
        }
        $update = substr($update, 0, -2);
        $sql = sprintf('UPDATE {{table_prefix}}%s SET %s%s',$table,$update,$query);
        DB::query($sql);
        $sql = sprintf("SELECT * FROM {{table_prefix}}%s%s ORDER BY id DESC LIMIT 1",$table,$query);
        $this->data = DB::getRow($sql);
    }

    protected function delete(){
        $this->buildQuery();
        $query = '  '.$this->query;
        $table = $this->table;
        $sql = sprintf('DELETE FROM {{table_prefix}}%s%s', $table, $query);
        DB::query($sql);
    }
}