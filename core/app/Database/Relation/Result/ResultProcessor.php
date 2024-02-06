<?php

namespace Ovolab\BackOffice\Database\Relation\Result;

use App\Facade\DB;

class ResultProcessor {

    public function getResult($data,$relation,$relationName){

        $primaryKey = $relation->primaryKey;
        $foreignKey = $relation->foreignKey;
        $data = $data;
        $shouldSingle = false;
        if (!is_array($data)) {
            $shouldSingle = true;
            $data = [$data];
        }

        $keyValues = $this->getKeyValues($data,$relation);

        $relationalQuery = @$relation->relational_query;
        if (!$relationalQuery) {
            $relationalQuery = new $relation->model;
        }
        $sql = $this->getSql($keyValues,$relation,$relationalQuery);
        $result = DB::execute($sql);

        foreach ($data as $item) {
            $filteredData = $this->getFilteredData($primaryKey,$foreignKey,$item,$result);
            $item->$relationName = $filteredData;
        }
        if ($shouldSingle) {
            return $data[0];
        }
        return $data;
    }
}