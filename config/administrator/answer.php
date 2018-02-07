<?php

use App\Answer;

return [
    'title'   => '问题回答',
    'single'  => '问题回答',
    'model'   => Answer::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
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
        'question' => [
            'title'    => '问题标题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                $title=$model->question->title;
                return $title;
            },
        ],
        'votes_count' => [
            'title'    => '点赞数',
        ],
        'comments_count' => [
            'title'    => '评论数',
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'votes_count' => [
            'title'    => '点赞数',
            'value'    =>0,
        ],
        'comments_count' => [
            'title'    => '评论数',
            'value'    =>0,
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
        'question' => [
            'title'              => '主题',
            'type'               => 'relationship',
            'name_field'         => 'title',

            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            'autocomplete'       => true,

            // 自动补全的搜索字段
            'search_fields'      => ["CONCAT(id, ' ', title)"],

            // 自动补全排序
            'options_sort_field' => 'id',
        ],
        'body' => [
            'title'    => '内容',
            'type' => 'textarea',
//            'limit' => 300, //optional, defaults to no limit
//            'height' => 130, //optional, defaults to 100
        ],
    ],
    'filters' => [

        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'question' => [
            'title'              => '主题',
            'type'               => 'relationship',
            'name_field'         => 'title',

            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            'autocomplete'       => true,

            // 自动补全的搜索字段
            'search_fields'      => ["CONCAT(id, ' ', title)"],

            // 自动补全排序
            'options_sort_field' => 'id',
        ],
    ],
    'rules'   => [
        'body' => 'required'
    ],
    'messages' => [
        'body.required' => '请填写回复内容',
    ],

];
