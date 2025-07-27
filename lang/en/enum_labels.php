<?php

return [
    'order_status' => [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid',
    ],
    
    'product_status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],
    
    'order_status' => [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid',
        'partial_paid' => 'Partial Paid',
        'over_paid' => 'Over Paid',
        'settled' => 'Settled',
    ],

    'sort_order' => [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ],
    
    'order_fields' => [
        'id' => 'Id',
        'customer_id' => 'Customer ID',
        'order_number' => 'Order Number',
        'sub_total' => 'Sub Total',
        'total' => 'Total',
        'due' => 'Due',
        'profit' => 'Profit',
        'loss' => 'Loss',
        'status' => 'Status',
        'created_at' => 'Created At',
    ],
    
    'order_sort_fields' => [
        'id' => 'Id',
        'customer_id' => 'Customer ID',
        'sub_total' => 'Sub Total',
        'discount_total' => 'Total Discount',
        'total' => 'Total',
        'paid' => 'Paid',
        'due' => 'Due',
        'profit' => 'Profit',
        'loss' => 'Loss',
        'status' => 'Status',
        'created_at' => 'Created At',
    ],
    
    'product_fields' => [
        'id' => 'Id',
        'keyword' => 'Keyword',
        'name' => 'Name',
        'product_number' => 'Product Number',
        'product_code' => 'Product Code',
        'category_id' => 'Category',
        'supplier_id' => 'Supplier',
        'buying_price' => 'Buying Price',
        'selling_price' => 'Selling Price',
        'buying_date' => 'Buying Date',
        'unit_type_id' => 'Unit Type',
        'quantity' => 'Quantity',
        'quantities' => 'Quantities',
        'status' => 'Status',
        'created_at' => 'Created At',
    ],
    
    'customer_fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'created_at' => 'Created At',
    ],
    
    'employee_fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'designation' => 'Designation',
        'nid' => 'NID',
        'salary' => 'Salary',
        'joining_date' => 'Joining Date',
        'created_at' => 'Created At',
    ],
    
    'supplier_fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'shop_name' => 'Shop Name',
        'created_at' => 'Created At',
    ],
    
    'supplier' => [
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'shop_name' => 'Shop Name',
    ],
    
    'category_fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'created_at' => 'Created At',
    ],
    
    'expense_fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'amount' => 'Amount',
        'expense_date' => 'Expense Date',
        'created_at' => 'Created At',
    ],
    
    'salary_fields' => [
        'id' => 'Id',
        'employee_id' => 'Employee',
        'amount' => 'Amount',
        'salary_date' => 'Salary Date',
        'created_at' => 'Created At',
    ],

    'transaction_fields' => [
        'id' => 'Id',
        'order_id' => 'Order',
        'transaction_number' => 'Transaction Number',
        'amount' => 'Amount',
        'paid_through' => 'Paid Through',
        'created_at' => 'Created At',
    ],
    
    'unit_type_fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'symbol' => 'Symbol',
        'created_at' => 'Created At',
    ],
    
    'user_fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email Verified At',
        'created_at' => 'Created At',
    ],
];