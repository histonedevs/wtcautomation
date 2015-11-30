<?php
use yajra\Datatables\Html\Builder;

/**
 * @param $data
 * @param $name
 * @param $title
 * @param $column_type
 * @param null $select_options
 * @param null $edit_template
 * @param bool $raw
 * @param null $width
 * @param string $class_name
 * @return array
 */
function make_column($data, $name, $title , $column_type,
                     $select_options = null , $edit_template=null, $raw=false, $width=null, $class_name="", $orderable = true){

    $column = [
        'data' => $data,
        'name' => $name,
        'title' => $title,
        "column_type" => $column_type ,
        "select_options" => $select_options,
        "edit_template" => $edit_template,
        "raw" => $raw,
        "orderable" => $orderable,
        "className" => $data == 'active' ? "active_column {$class_name}" : "{$data} {$class_name}"


    ];

    if($width){
        $column["width"] = $width;
    }

    return $column;
}

/**
 * @param Builder $htmlBuilder
 * @param $columns
 * @param $base_query
 * @param $url
 * @param array $order
 * @return $this
 */
function build_data_table(Builder $htmlBuilder, &$columns , $base_query , $url , $order = [], $fixed_cols = 0 ){
    $c = count($columns);
    for($i=0; $i<$c; $i++){
        if($columns[$i]['column_type'] == 'select'){
            $columns[$i]['select_options'] = get_distinct_array(
                $base_query ,
                $columns[$i]['name'] ,
                "Select {$columns[$i]['title']}"
            );
        }
    }

    $data_table = $htmlBuilder->columns($columns)->ajax($url);
    $data_table->parameters([
        'sDom' => "<'row'<'col-sm-3 dt-entries'l><'col-sm-4 additional-filters'><'col-sm-5 dt-searchbox'f>><'row'<'col-sm-12 dt-container'tr>><'row'<'col-sm-5 dt-info'i><'col-sm-7 dt-paging'p>>",
        "order" => $order,
        "bStateSave" => true,
        "colReorder" => [
            "fixedColumnsRight" => $fixed_cols
        ]
    ]);
    return $data_table;
}
function data_table_columns_in_drop_down($data_table){
    $html = '<div class="dropdown" id="dropdown_selector">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdown_selector_btn"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    $html.=trans('menu.columns');

    $html.='&nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span>
                </button>
                <ul class="dropdown-menu custom-menu" aria-labelledby="dropdown_selector_btn">';

    foreach($data_table->collection as $column){
        if($column->title != ''){
            $html.= '<li>
                            <span>
                                <input type="checkbox" checked class="checkbox" name="';

            $html.= "{$column->className}";

            $html.= '">
                        ';

            $html.="{$column->title}";

            $html.='</span>
                </li>';
        }

    }

    $html.= '</ul></div>';
    return $html;


}

class MyDataTableBuilder extends Builder{
    public static function make_scripts(Builder $data_table, array $attributes = ['type' => 'text/javascript']){
        $args = array_merge(
            $data_table->attributes, [
                'ajax'    => $data_table->ajax,
                'columns' => $data_table->collection->toArray(),
            ]
        );

        $parameters = $data_table->parameterize($args);

        $script = sprintf('(function(window,$){
            var dt_params = %s;
            if(window.additional_dt_params){
                $.extend(dt_params, window.additional_dt_params);
            }
            window.LaravelDataTables=window.LaravelDataTables||{};
            window.LaravelDataTables["%s"]=$("#%s").DataTable(dt_params);
         })(window,jQuery);', $parameters , $data_table->tableAttributes['id'], $data_table->tableAttributes['id']);

        return '<script' . $data_table->html->attributes($attributes) . '>' . $script . '</script>' . PHP_EOL;
    }
}

function makeScripts($data_table){
    return MyDataTableBuilder::make_scripts($data_table);
}