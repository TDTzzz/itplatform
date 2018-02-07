<?php

use App\postComment;

return [
    'title'   => '文章评论',
    'single'  => '文章评论',
    'model'   => postComment::class,
    //可见选项


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
        'post' => [
            'title'    => '文章标题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                $title=$model->post->title;
                return $title;
            },
        ],
        'body' => [
            'title'    => '内容',
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],

    ],
    'edit_fields' => [

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
        'post' => [
            'title'              => '文章',
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
            'type'     => 'textarea',
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
        'post' => [
            'title'              => '文章标题',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],

    ],

    'rules'   => [
        'user_id' => 'required',
        'post_id' => 'required',
        'body' => 'required'
    ],
    'messages' => [
        'user_id.required' => '请填用户',
        'post_id.required' => '请填写文章',
        'body.required' => '请填写回复内容',
    ],


];
