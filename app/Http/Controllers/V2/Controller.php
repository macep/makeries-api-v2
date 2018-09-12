<?php

namespace App\Http\Controllers\V2;
use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function useFilter($request, $objectName) {
        $class = 'App\\'.$objectName;
        if (class_exists($class)) {
            $object  = new $class;
            $tableName = $this->decamelize($objectName).'s';
            $objectSearch = $class::select($tableName . '.*')->where($tableName.'.id','>=',1);
            return $this->applyFilter($request, $objectSearch, $object->filterable);
        }
        return null;
    }

    public function applyFilter($request, $searchObject, $filters) {
        foreach ($filters as $filterType=>$fields) {
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    switch ($filterType) {
                        case 'number':
                            $value = $request->$field;
                            $searchObject = $searchObject->where($field, $value);
                            break;
                        case 'string':
                            $filterMode = 'LIKE';
                            $value = $request->$field;
                            if('{' == substr($value,0,1)) {
                                $filterMode = substr($value,0,strpos($value, '}')+1);
                                $value = substr($value,strpos($value, '}')+1);
                            }
                            switch ($filterMode) {
                               case '{all}':
                                    $values = explode(',',$value);
                                    foreach ($values as $aValue) {
                                        $searchObject = $searchObject->where($field, 'LIKE', '%'.$aValue.'%');
                                    }
                                    break;
                               case '{nin}':
                                    $values = explode(',',$value);
                                    foreach ($values as $aValue) {
                                        $searchObject = $searchObject->where($field, 'NOT LIKE', '%'.$aValue.'%');
                                    }
                                    break;
                               case '{exact}':
                                    $filterMode = 'LIKE';
                                    $searchObject = $searchObject->where($field, 'LIKE', $value);
                                    break;
                                case '{not}':
                                    $searchObject = $searchObject->where($field, 'NOT LIKE', '%'.$value.'%');
                                    break;
                                case '':
                                default:
                                    $searchObject = $searchObject->where($field, 'LIKE', '%'.$value.'%');
                                    break;
                            }
                            break;
                    }
                }
            }
        }
        return $searchObject;
    }

    public function getSearchData(Request $request, $object) {
        $count = $object->count();

        $sort    = $request->get('sort_by');
        $perPage = $request->get('per_page',10);
        $offset  = $request->get('page',1);

        $sortData = explode(',', $sort);
        $results = $object->limit($perPage)->offset(($offset-1)*$perPage);
        if (strlen($sortData[0])) {
            $results = $results->orderBy($sortData[0], isset($sortData[1]) && strlen($sortData[1]) ? $sortData[1] : 'asc');
        }
        return [
            'count' => $count,
            'results' => $results->get()
        ];
    }

    function decamelize($word) {
        return strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/',"_$1", $word));
    }
}
