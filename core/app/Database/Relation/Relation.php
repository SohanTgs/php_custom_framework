<?php

namespace App\Database\Relation;

trait Relation{

    protected function with($relations){

        foreach ($relations as $key => $relation) {
            if (!is_int($key)) {
                $name = $key;
                $callback = $relation;
            }else{
                $name = $relation;
                $callback = null;
            }
            if (!method_exists($this,$name)) {
                throw new \Exception("Undefined relation $name");
            }
            $this->tempRelationName = $name;
            $executeRelation = $this->$name();
            if ($callback && is_callable($callback)) {
                $relQuery = $callback($executeRelation);
                if ($relQuery) {
                    $this->relations[$name] = array_merge($this->relations[$name],['relational_query'=>$relQuery]);
                }
            }
            $this->relations[$name] = array_merge($this->relations[$name],['query_type'=>'data']);
            $this->tempRelationName = null;
        }

    }

    protected function withCount($relations){
        foreach ($relations as $key => $relation) {
            if (!is_int($key)) {
                $name = $key;
                $callback = $relation;
            }else{
                $name = $relation;
                $callback = null;
            }
            
            if (!method_exists($this,$name)) {
                throw new \Exception("Undefined relation $name");
            }
            $this->tempRelationName = $name;
            $executeRelation = $this->$name();
            $query = null;
            if ($callback && is_callable($callback)) {
                $relQuery = $callback($executeRelation);
                if ($relQuery) {
                    $query = $relQuery->getCondition();
                }
            }
            
            $relation = $this->relations[$name];
            $model = new $relation['model'];
            $relationTableName = $model->table;
            $tableName = $this->table;
            $primaryKey = $relation['primaryKey'];
            $foreignKey = $relation['foreignKey'];
            $condition = 'WHERE';
            if (preg_match("/\bWHERE\b/i", $query)) {
                $condition = 'AND';
            }
            
            $query = "SELECT COUNT(*) FROM {{table_prefix}}$relationTableName $query";

            if ($relation['type'] == 'belongsTo') {
                $key1 = $primaryKey;
                $key2 = $foreignKey;
            }else{
                $key1 = $foreignKey;
                $key2 = $primaryKey;
            }
            $query = $query." $condition `{{table_prefix}}$relationTableName`.`$key1` = `{{table_prefix}}$tableName`.`$key2`";
            $query = "($query) as $name"."_count";

            $this->withRelation[$name] = $query;
            $this->relations = null;
        }
    }

    protected function withSum($relations){
        foreach ($relations as $key => $relInfo) {
            if (!is_int($key)) {
                $key = explode(':',$key);
                $relation = $key[0];
                $column = $key[1];

                $name = $relation;
                $callback = $relInfo;
            }else{

                $relInfo = explode(':',$relInfo);
                $relation = $relInfo[0];
                $column = $relInfo[1];

                $name = $relation;
                $callback = null;
            }
            
            if (!method_exists($this,$name)) {
                throw new \Exception("Undefined relation $name");
            }
            $this->tempRelationName = $name;
            $executeRelation = $this->$name();
            $query = null;
            if ($callback && is_callable($callback)) {
                $relQuery = $callback($executeRelation);
                if ($relQuery) {
                    $query = $relQuery->getCondition();
                }
            }
            
            $relation = $this->relations[$name];
            $model = new $relation['model'];
            $relationTableName = $model->table;
            $tableName = $this->table;
            $primaryKey = $relation['primaryKey'];
            $foreignKey = $relation['foreignKey'];
            $condition = 'WHERE';
            if (preg_match("/\bWHERE\b/i", $query)) {
                $condition = 'AND';
            }
            
            $query = "SELECT SUM(`{{table_prefix}}$relationTableName`.`$column`) FROM {{table_prefix}}$relationTableName $query";
            
            if ($relation['type'] == 'belongsTo') {
                $key1 = $primaryKey;
                $key2 = $foreignKey;
            }else{
                $key1 = $foreignKey;
                $key2 = $primaryKey;
            }
            $query = $query." $condition `{{table_prefix}}$relationTableName`.`$key1` = `{{table_prefix}}$tableName`.`$key2`";
            $query = "($query) as $name"."_sum";
            $this->withRelation[$name] = $query;
            $this->relations = null;
        }
    }

    protected function withAvg($relations){
        foreach ($relations as $key => $relInfo) {
            if (!is_int($key)) {
                $key = explode(':',$key);
                $relation = $key[0];
                $column = $key[1];

                $name = $relation;
                $callback = $relInfo;
            }else{

                $relInfo = explode(':',$relInfo);
                $relation = $relInfo[0];
                $column = $relInfo[1];

                $name = $relation;
                $callback = null;
            }
            
            if (!method_exists($this,$name)) {
                throw new \Exception("Undefined relation $name");
            }
            $this->tempRelationName = $name;
            $executeRelation = $this->$name();
            $query = null;
            if ($callback && is_callable($callback)) {
                $relQuery = $callback($executeRelation);
                if ($relQuery) {
                    $query = $relQuery->getCondition();
                }
            }
            
            $relation = $this->relations[$name];
            $model = new $relation['model'];
            $relationTableName = $model->table;
            $tableName = $this->table;
            $primaryKey = $relation['primaryKey'];
            $foreignKey = $relation['foreignKey'];
            $condition = 'WHERE';
            if (preg_match("/\bWHERE\b/i", $query)) {
                $condition = 'AND';
            }
            
            $query = "SELECT AVG(`{{table_prefix}}$relationTableName`.`$column`) FROM {{table_prefix}}$relationTableName $query";
            
            if ($relation['type'] == 'belongsTo') {
                $key1 = $primaryKey;
                $key2 = $foreignKey;
            }else{
                $key1 = $foreignKey;
                $key2 = $primaryKey;
            }
            $query = $query." $condition `{{table_prefix}}$relationTableName`.`$key1` = `{{table_prefix}}$tableName`.`$key2`";
            $query = "($query) as $name"."_avg";
            $this->withRelation[$name] = $query;
            $this->relations = null;
        }
    }

    protected function withMin($relations){
        foreach ($relations as $key => $relInfo) {
            if (!is_int($key)) {
                $key = explode(':',$key);
                $relation = $key[0];
                $column = $key[1];

                $name = $relation;
                $callback = $relInfo;
            }else{

                $relInfo = explode(':',$relInfo);
                $relation = $relInfo[0];
                $column = $relInfo[1];

                $name = $relation;
                $callback = null;
            }
            
            if (!method_exists($this,$name)) {
                throw new \Exception("Undefined relation $name");
            }
            $this->tempRelationName = $name;
            $executeRelation = $this->$name();
            $query = null;
            if ($callback && is_callable($callback)) {
                $relQuery = $callback($executeRelation);
                if ($relQuery) {
                    $query = $relQuery->getCondition();
                }
            }
            
            $relation = $this->relations[$name];
            $model = new $relation['model'];
            $relationTableName = $model->table;
            $tableName = $this->table;
            $primaryKey = $relation['primaryKey'];
            $foreignKey = $relation['foreignKey'];
            $condition = 'WHERE';
            if (preg_match("/\bWHERE\b/i", $query)) {
                $condition = 'AND';
            }
            
            $query = "SELECT MIN(`{{table_prefix}}$relationTableName`.`$column`) FROM {{table_prefix}}$relationTableName $query";
            
            if ($relation['type'] == 'belongsTo') {
                $key1 = $primaryKey;
                $key2 = $foreignKey;
            }else{
                $key1 = $foreignKey;
                $key2 = $primaryKey;
            }
            $query = $query." $condition `{{table_prefix}}$relationTableName`.`$key1` = `{{table_prefix}}$tableName`.`$key2`";
            $query = "($query) as $name"."_min";
            $this->withRelation[$name] = $query;
            $this->relations = null;
        }
    }

    protected function withMax($relations){
        foreach ($relations as $key => $relInfo) {
            if (!is_int($key)) {
                $key = explode(':',$key);
                $relation = $key[0];
                $column = $key[1];

                $name = $relation;
                $callback = $relInfo;
            }else{

                $relInfo = explode(':',$relInfo);
                $relation = $relInfo[0];
                $column = $relInfo[1];

                $name = $relation;
                $callback = null;
            }
            
            if (!method_exists($this,$name)) {
                throw new \Exception("Undefined relation $name");
            }
            $this->tempRelationName = $name;
            $executeRelation = $this->$name();
            $query = null;
            if ($callback && is_callable($callback)) {
                $relQuery = $callback($executeRelation);
                if ($relQuery) {
                    $query = $relQuery->getCondition();
                }
            }
            
            $relation = $this->relations[$name];
            $model = new $relation['model'];
            $relationTableName = $model->table;
            $tableName = $this->table;
            $primaryKey = $relation['primaryKey'];
            $foreignKey = $relation['foreignKey'];
            $condition = 'WHERE';
            if (preg_match("/\bWHERE\b/i", $query)) {
                $condition = 'AND';
            }
            
            $query = "SELECT MAX(`{{table_prefix}}$relationTableName`.`$column`) FROM {{table_prefix}}$relationTableName $query";
            
            if ($relation['type'] == 'belongsTo') {
                $key1 = $primaryKey;
                $key2 = $foreignKey;
            }else{
                $key1 = $foreignKey;
                $key2 = $primaryKey;
            }
            $query = $query." $condition `{{table_prefix}}$relationTableName`.`$key1` = `{{table_prefix}}$tableName`.`$key2`";
            $query = "($query) as $name"."_max";
            $this->withRelation[$name] = $query;
            $this->relations = null;
        }
    }

    protected function whereHas($relations){
        foreach ($relations as $key => $relation) {
            if (!is_int($key)) {
                $name = $key;
                $callback = $relation;
            }else{
                $name = $relation;
                $callback = null;
            }
            
            if (!method_exists($this,$name)) {
                throw new \Exception("Undefined relation $name");
            }
            $this->tempRelationName = $name;
            $executeRelation = $this->$name();
            $query = null;
            if ($callback && is_callable($callback)) {
                $relQuery = $callback($executeRelation);
                if ($relQuery) {
                    $query = $relQuery->getQuery(true);
                }
            }
            
            $relation = $this->relations[$name];
            $model = new $relation['model'];
            $relationTableName = $model->table;
            $tableName = $this->table;
            $primaryKey = $relation['primaryKey'];
            $foreignKey = $relation['foreignKey'];
            $condition = 'WHERE';
            if (preg_match("/\bWHERE\b/i", $query)) {
                $condition = 'AND';
            }
            if (!$query) {
                $query = "SELECT * FROM {{table_prefix}}$relationTableName";
            }
            
            if ($relation['type'] == 'belongsTo') {
                $key1 = $primaryKey;
                $key2 = $foreignKey;
            }else{
                $key1 = $foreignKey;
                $key2 = $primaryKey;
            }
            $query = $query." $condition `{{table_prefix}}$relationTableName`.`$key1` = `{{table_prefix}}$tableName`.`$key2`";
            $query = "EXISTS ($query)";
            $this->relationalQuery[$name] = $query;
            $this->relations = null;
        }
    }
}