<?php

return [
    'name' => 'Tồn kho sản phẩm',
    'storehouse_management' => 'Quản lý kho',

    'import' => [
        'name' => 'Cập nhật tồn kho sản phẩm',
        'description' => 'Cập nhật tồn kho sản phẩm hàng loạt bằng cách tải lên file CSV/Excel.',
        'done_message' => 'Đã cập nhật :count sản phẩm thành công.',
        'rules' => [
            'id' => 'Trường ID là bắt buộc và phải tồn tại trong bảng sản phẩm.',
            'name' => 'Trường tên là bắt buộc và phải là chuỗi.',
            'sku' => 'Trường SKU phải là chuỗi.',
            'with_storehouse_management' => 'Trường quản lý kho phải là "Yes" hoặc "No".',
            'quantity' => 'Trường số lượng là bắt buộc khi quản lý kho là "Yes".',
            'stock_status' => 'Trường trạng thái kho là bắt buộc khi quản lý kho là "No" và phải là một trong các giá trị sau: :statuses.',
        ],
    ],

    'export' => [
        'description' => 'Xuất tồn kho sản phẩm ra file CSV/Excel.',
    ],
];
