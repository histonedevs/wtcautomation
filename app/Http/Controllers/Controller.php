<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function isAjax(Request $request)
    {
        return ($request->ajax() || $request->get("ajax"));
    }

    protected function dataTable(Array $columns, Request $request, $data_table, $tz="+00:00")
    {
        $column_types = [];
        foreach ($columns as $column) {
            if ($column['data'] && $column['edit_template']) {
                $data_table->editColumn($column['data'], $column['edit_template']);
            }
            $column_types[$column['name']] = $column;
        }

        $data_table->filter(function ($query) use ($request, $column_types, $tz) {
            if ($request->has('custom_filter')) {
                $custom_filter = $request->get('custom_filter');
                foreach ($custom_filter as $column_name => $filter_value) {
                    if ($filter_value) {
                        $is_raw = @$column_types[$column_name]['raw'];
                        $having = str_contains($column_name, ['count(', 'sum(', 'avg(']);
                        $rawFunc = ($is_raw) ? (($having) ? "havingRaw" : "whereRaw") : "";

                        switch ($column_types[$column_name]['column_type']) {
                            case 'text':
                                $filter_value = addslashes($filter_value);
                                if ($is_raw) {
                                    $query->$rawFunc("{$column_name} LIKE '%{$filter_value}%'");
                                } else {
                                    $query->where($column_name, "LIKE", "%{$filter_value}%");
                                }
                                break;
                            case 'number':
                                if (@$filter_value['from']) {
                                    $filter_value['from'] = addslashes($filter_value['from']);
                                    if ($is_raw) {
                                        $query->$rawFunc("{$column_name} >= '{$filter_value['from']}'");
                                    } else {
                                        $query->where($column_name, ">=", $filter_value['from']);
                                    }
                                }

                                if (@$filter_value['to']) {
                                    $filter_value['to'] = addslashes($filter_value['to']);
                                    if ($is_raw) {
                                        $query->$rawFunc("{$column_name} <= '{$filter_value['to']}'");
                                    } else {
                                        $query->where($column_name, "<=", $filter_value['to']);
                                    }
                                }
                                break;
                            case 'date':
                                if (@$filter_value['from']) {
                                    try {
                                        $filter_value['from'] = addslashes($filter_value['from']);
                                        if ($is_raw) {
                                            throw new \Exception("Raw filtering not enabled for date types");
                                            //$query->whereRaw("");
                                        } else {
                                            $query->whereRaw("CONVERT_TZ($column_name,'+00:00','{$tz}') >= '".Carbon::parse($filter_value['from'])."'");
                                        }
                                    } catch (\Exception $ex) {

                                    }
                                }

                                if (@$filter_value['to']) {
                                    try {
                                        $filter_value['to'] = addslashes($filter_value['to']);
                                        if ($is_raw) {
                                            throw new \Exception("Raw filtering not enabled for date types");
                                            //$query->whereRaw("");
                                        } else {
                                            $query->whereRaw("CONVERT_TZ($column_name,'+00:00','{$tz}') <= '".Carbon::parse($filter_value['to'])."'");
                                        }
                                    } catch (\Exception $ex) {

                                    }
                                }
                                break;
                            case 'select':
                                $filter_value = addslashes($filter_value);
                                if ($is_raw) {
                                    $query->$rawFunc("{$column_name} = '{$filter_value}'");
                                } else {
                                    $query->where($column_name, "=", $filter_value);
                                }
                                break;
                        }
                    }
                }
            }

            if ($request->has('search')) {
                $search = $request->get('search');
                if (@$search['value']) {
                    $search_value = addslashes($search['value']);
                    $query->where(function ($_query) use ($column_types, $search_value) {
                        foreach ($column_types as $column_name => $column) {
                            if (in_array($column['column_type'], ['text', 'select'])) {
                                $_query->orWhereRaw("{$column_name} LIKE '%{$search_value}%'");
                            }
                        }
                    });
                }
            }
        });

        return $data_table;
    }
}
