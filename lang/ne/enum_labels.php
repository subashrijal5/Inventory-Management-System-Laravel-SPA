<?php

return [
    'order_status' => [
        'paid' => 'भुक्तान गरिएको',
        'unpaid' => 'भुक्तान नगरिएको',
    ],
    
    'product_status' => [
        'active' => 'सक्रिय',
        'inactive' => 'निष्क्रिय',
    ],
    
    'order_status' => [
        'paid' => 'भुक्तान गरिएको',
        'unpaid' => 'भुक्तान नगरिएको',
        'partial_paid' => 'आंशिक भुक्तान',
        'over_paid' => 'अधिक भुक्तान',
        'settled' => 'समाधान गरिएको',
    ],

    'sort_order' => [
        'asc' => 'बढ्दो',
        'desc' => 'घट्दो',
    ],
    
    'order_fields' => [
        'id' => 'आईडी',
        'customer_id' => 'ग्राहक आईडी',
        'order_number' => 'अर्डर नम्बर',
        'sub_total' => 'उप जम्मा',
        'total' => 'जम्मा',
        'due' => 'बाँकी',
        'profit' => 'नाफा',
        'loss' => 'नोक्सान',
        'status' => 'स्थिति',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'order_sort_fields' => [
        'id' => 'आईडी',
        'customer_id' => 'ग्राहक आईडी',
        'sub_total' => 'उप जम्मा',
        'discount_total' => 'कुल छुट',
        'total' => 'जम्मा',
        'paid' => 'भुक्तान गरिएको',
        'due' => 'बाँकी',
        'profit' => 'नाफा',
        'loss' => 'नोक्सान',
        'status' => 'स्थिति',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'product_fields' => [
        'id' => 'आईडी',
        'keyword' => 'खोजशब्द',
        'name' => 'नाम',
        'product_number' => 'उत्पादन नम्बर',
        'product_code' => 'उत्पादन कोड',
        'category_id' => 'श्रेणी',
        'supplier_id' => 'आपूर्तिकर्ता',
        'buying_price' => 'खरिद मूल्य',
        'selling_price' => 'बिक्री मूल्य',
        'buying_date' => 'खरिद मिति',
        'unit_type_id' => 'एकाइ प्रकार',
        'quantity' => 'मात्रा',
        'quantities' => 'मात्रा',
        'status' => 'स्थिति',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'customer_fields' => [
        'id' => 'आईडी',
        'name' => 'नाम',
        'email' => 'इमेल',
        'phone' => 'फोन',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'employee_fields' => [
        'id' => 'आईडी',
        'name' => 'नाम',
        'email' => 'इमेल',
        'phone' => 'फोन',
        'designation' => 'पद',
        'nid' => 'राष्ट्रिय परिचयपत्र',
        'salary' => 'तलब',
        'joining_date' => 'सामेल भएको मिति',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'supplier_fields' => [
        'id' => 'आईडी',
        'name' => 'नाम',
        'email' => 'इमेल',
        'phone' => 'फोन',
        'shop_name' => 'पसल नाम',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'supplier' => [
        'name' => 'नाम',
        'email' => 'इमेल',
        'phone' => 'फोन',
        'shop_name' => 'पसल नाम',
    ],
    
    'category_fields' => [
        'id' => 'आईडी',
        'name' => 'नाम',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'expense_fields' => [
        'id' => 'आईडी',
        'name' => 'नाम',
        'amount' => 'रकम',
        'expense_date' => 'खर्च मिति',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'salary_fields' => [
        'id' => 'आईडी',
        'employee_id' => 'कर्मचारी',
        'amount' => 'रकम',
        'salary_date' => 'तलब मिति',
        'created_at' => 'सिर्जना मिति',
    ],

    'transaction_fields' => [
        'id' => 'आईडी',
        'order_id' => 'अर्डर',
        'transaction_number' => 'लेनदेन नम्बर',
        'amount' => 'रकम',
        'paid_through' => 'भुक्तानी माध्यम',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'unit_type_fields' => [
        'id' => 'आईडी',
        'name' => 'नाम',
        'symbol' => 'प्रतीक',
        'created_at' => 'सिर्जना मिति',
    ],
    
    'user_fields' => [
        'id' => 'आईडी',
        'name' => 'नाम',
        'email' => 'इमेल',
        'email_verified_at' => 'इमेल प्रमाणित मिति',
        'created_at' => 'सिर्जना मिति',
    ],
];