<?php

return [
    'product_specification' => 'Thông số sản phẩm',
    'specification_groups' => [
        'title' => 'Nhóm thông số',

        'create' => [
            'title' => 'Tạo nhóm thông số',
        ],

        'edit' => [
            'title' => 'Chỉnh sửa nhóm thông số ":name"',
        ],
    ],

    'specification_attributes' => [
        'title' => 'Thuộc tính thông số',

        'group' => 'Nhóm liên kết',
        'group_placeholder' => 'Chọn nhóm bất kỳ',
        'type' => 'Loại trường',
        'default_value' => 'Giá trị mặc định',
        'options' => [
            'heading' => 'Tùy chọn',

            'add' => [
                'label' => 'Thêm tùy chọn mới',
            ],
        ],

        'create' => [
            'title' => 'Tạo thuộc tính thông số',
        ],

        'edit' => [
            'title' => 'Chỉnh sửa thuộc tính thông số ":name"',
        ],
    ],

    'specification_tables' => [
        'title' => 'Bảng thông số',

        'create' => [
            'title' => 'Tạo bảng thông số',
        ],

        'edit' => [
            'title' => 'Chỉnh sửa bảng thông số ":name"',
        ],

        'fields' => [
            'groups' => 'Chọn các nhóm để hiển thị trong bảng này',
            'name' => 'Tên nhóm',
            'assigned_groups' => 'Nhóm đã gán',
            'sorting' => 'Sắp xếp',
        ],
    ],

    'product' => [
        'specification_table' => [
            'options' => 'Tùy chọn',
            'title' => 'Bảng thông số',
            'select_none' => 'Không có',
            'description' => 'Chọn bảng thông số để hiển thị trong sản phẩm này',
            'group' => 'Nhóm',
            'attribute' => 'Thuộc tính',
            'value' => 'Giá trị thuộc tính',
            'hide' => 'Ẩn',
            'sorting' => 'Sắp xếp',
        ],
    ],

    'enums' => [
        'field_types' => [
            'text' => 'Văn bản',
            'textarea' => 'Văn bản dài',
            'select' => 'Chọn',
            'checkbox' => 'Checkbox',
            'radio' => 'Radio',
        ],
    ],
];
