<?php

namespace App\Database;

use App\Database\Relation\ExecuteRelation;
use App\Database\Relation\Relation;
use App\Database\Relation\RelationalResult;

class Model
{
    public $where = [];
    public $orWhere = [];
    public $whereIn = [];
    public $whereNotIn = [];
    public $whereBetween = [];
    public $limit;
    public $skip;
    public $orderBy = [];

    protected $table;
    protected $data;
    protected static $model; 

    public $relations = [];
    protected $tempRelationName;

    protected $paginationCall = false;
    protected $pagination;

    protected $relationalQuery = [];
    protected $withRelation = [];

    use QueryBuilder, ConditionBuilder, Relation, ExecuteRelation, RelationalResult;

    public function __call($name, $arguments)
    {
        self::$model = static::class;  // Changed static::$model to self::$model
        $name = static::checkMethod($this, $name);
        if (preg_match('/scope/i', $name)) {
            $arguments = array_merge([$this], $arguments);
        }
        $this->$name(...$arguments);
        if (isset($this->data) || (is_int($this->data) && $this->data == (int)0)) {

            if (!empty($this->relations)) {
                $this->manageRelationalResult();
            }

            if ($this->data == 'no-data') {
                $data = null;
            } else {
                if ($this->paginationCall) {
                    $data = toObject([
                        'data' => $this->data,
                        'pagination' => $this->pagination
                    ]);
                } else {
                    $data = $this->data;
                }
            }

            return $data;
        }
        return $this;
    }

    public static function __callStatic($name, $arguments)
    {   
        self::$model = static::class;  // Changed static::$model to self::$model
        $c = new static;
        $name = static::checkMethod($c, $name);
        if (preg_match('/scope/i', $name)) {
            $arguments = array_merge([$c], $arguments);
        }

        $c->$name(...$arguments);
        if (isset($c->data) || (is_int($c->data) && $c->data == (int)0)) {

            if ($c->data == 'no-data') {
                $data = null;
            } else {
                if (@$c->paginationCall) {
                    $data = toObject([
                        'data' => $c->data,
                        'pagination' => $c->pagination
                    ]);
                } else {
                    $data = $c->data;
                }
            }
            return $data;
        }
        return $c;
    }

    private static function checkMethod($obj, $name)
    {
        if (!method_exists($obj, $name)) {
            $name = 'scope' . ucfirst($name);
            if (!method_exists($obj, $name)) {
                throw new \Exception("Undefined method $name");
            }
        }
        return $name;
    }
}
