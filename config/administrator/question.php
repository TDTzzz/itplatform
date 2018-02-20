<?php

use App\Question;

return [
    'title'   => '问题',
    'single'  => '问题',
    'model'   => Question::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'    => '标题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return '<div style="max-width:260px">' . model_link($value, $model) . '</div>';
            },
        ],
        'user' => [
            'title'    => '作者',
            'sortable' => false,
            'output'   => function ($value, $model) {
                $avatar = $model->user->avatar;
                $value = empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" style="height:22px;width:22px"> ' . $model->user->name;
                return model_link($value, $model);
            },
        ],
        'topics' => [
            'title'    => '主题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                $value='';
                foreach ($model->topics as $k=>$v){
                    $value.= '<span style="height:22px;width:30px"> ' .$v->name.'</span>';
                }
                return $value;
            },
        ],
        'comments_count' => [
            'title'    => '评论数',
        ],
        'followers_count' => [
            'title'    => '关注数',
        ],
        'answers_count' => [
            'title'    => '回答数',
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title'    => '标题',
        ],
        'comments_count' => [
            'title'    => '评论数',
            'value'    =>  0,
        ],
        'followers_count' => [
            'title'    => '关注数',
            'value'    =>  0,

        ],
        'answers_count' => [
            'title'    => '回答数',
            'value'    =>  0,

        ],
        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',

            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            'autocomplete'       => true,

            // 自动补全的搜索字段
            'search_fields'      => ["CONCAT(id, ' ', name)"],

            // 自动补全排序
            'options_sort_field' => 'id',
        ],
        'topics' => [
            'title'              => '主题',
            'type'               => 'relationship',
            'name_field'         => 'name',

            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            'autocomplete'       => true,

            // 自动补全的搜索字段
            'search_fields'      => ["CONCAT(id, ' ', name)"],

            // 自动补全排序
            'options_sort_field' => 'id',
        ],
        'body' => [
            'title'    => '内容',
            'type' => 'textarea',
            'limit' => 10000, //optional, defaults to no limit
            'height' => 130, //optional, defaults to 100
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '内容 ID',
        ],
        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
    ],
    'rules'   => [
        'title' => 'required'
    ],
    'messages' => [
        'title.required' => '请填写标题',
    ],
];
