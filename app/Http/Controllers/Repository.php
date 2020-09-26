<?php

namespace App\Http\Controllers;

class Repository
{
    public function filter($model, $columns = null)
    {
        if ($columns != null) {
            foreach ($columns as $key => $column) {
                $key = key($column);
                $column = $column[$key];
                if (is_array($column)) {
                    $operator = $column['operator'] ?? '=';
                    $value = $column['value'] ?? '';
                    switch ($operator) {
                        case 'in' : $model = $model->inArray($key, $value); break;
                        case 'not_in' : $model = $model->notInArray($key, $value); break;
                        case 'like' : $model = $model->where($key, $operator, '%'. $value .'%'); break;
                        default : $model = $model->where($key, $operator, $value); break;
                    }
                } else $model = $model->where($key, $column);
            }
        }
        return $model;
    }
}
