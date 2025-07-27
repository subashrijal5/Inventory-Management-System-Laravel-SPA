export default {
    // Navigation
    navigation: {
        dashboard: 'Dashboard',
        products: 'Products',
        categories: 'Categories',
        suppliers: 'Suppliers',
        customers: 'Customers',
        employees: 'Employees',
        orders: 'Orders',
        transactions: 'Transactions',
        expenses: 'Expenses',
        salary: 'Salary',
        reports: 'Reports',
        settings: 'Settings',
        logout: 'Logout',
        profile: 'Profile',
        pos: 'POS',
        unit_types: 'Unit Types',
        search: 'Search...',
        users: 'Users'
    },

    // Transaction
    transaction: {
        transaction_number: 'Transaction Number',
        order_number: 'Order Number',
        amount: 'Amount',
        paid_through: 'Paid Through'
    },

    // Unit Type
    unit_type: {
        unit_types: 'Unit Types',
        create_unit_type: 'Create Unit Type',
        edit_unit_type: 'Edit Unit Type',
        symbol: 'Symbol',
        enter_symbol: 'Enter symbol',
        confirm_delete_unit_type: 'Are you sure you want to delete this unit type?',
        confirm_delete_button: 'Yes, delete it!'
    },

    // Salary
    salary: {
        pay_salary: 'Pay Salary',
        amount: 'Amount',
        salary_date: 'Salary Date',
        select_employee: 'Select Employee',
        enter_amount: 'Enter amount',
        enter_salary_date: 'Enter salary date',
        confirm_delete_salary: 'Are you sure you want to delete this salary?',
        confirm_delete_button: 'Yes, delete it!'
    },

    // Common actions
    actions: {
        add: 'Add',
        create: 'Create',
        edit: 'Edit',
        delete: 'Delete',
        save: 'Save',
        cancel: 'Cancel',
        confirm: 'Confirm',
        submit: 'Submit',
        reset: 'Reset',
        search: 'Search',
        filter: 'Filter',
        export: 'Export',
        import: 'Import',
        view: 'View',
        update: 'Update',
        print: 'Print',
        go_back: 'Go Back'
    },

    // Status
    status: {
        active: 'Active',
        inactive: 'Inactive',
        pending: 'Pending',
        completed: 'Completed',
        cancelled: 'Cancelled',
        processing: 'Processing',
        approved: 'Approved',
        rejected: 'Rejected',
        draft: 'Draft',
        published: 'Published'
    },

    // Enum Labels
    enum_labels: {
        // Order Status
        order_status: {
            paid: 'Paid',
            unpaid: 'Unpaid',
            partial_paid: 'Partial Paid',
            over_paid: 'Over Paid',
            settled: 'Settled'
        },
        // Product Status
        product_status: {
            active: 'Active',
            inactive: 'Inactive'
        },
        // Sort Order
        sort_order: {
            asc: 'ASC',
            desc: 'DESC'
        },
        // Order Fields
        order_fields: {
            id: 'ID',
            customer_id: 'Customer ID',
            order_number: 'Order Number',
            sub_total: 'Sub Total',
            total: 'Total',
            due: 'Due',
            profit: 'Profit',
            loss: 'Loss',
            status: 'Status'
        }
    },

    // Common fields
    fields: {
        name: 'Name',
        email: 'Email',
        password: 'Password',
        phone: 'Phone',
        address: 'Address',
        description: 'Description',
        price: 'Price',
        quantity: 'Quantity',
        date: 'Date',
        time: 'Time',
        status: 'Status',
        created_at: 'Created At',
        updated_at: 'Updated At',
        image: 'Image',
        category: 'Category',
        supplier: 'Supplier',
        code: 'Code',
        notes: 'Notes',
        customer: 'Customer',
        employee: 'Employee',
        action: 'Action',
        order_number: 'Order Number',
        paid: 'Paid',
        due: 'Due',
        profit: 'Profit',
        loss: 'Loss'
    },

    // Common messages
    messages: {
        success: 'Operation completed successfully',
        error: 'An error occurred',
        warning: 'Warning',
        info: 'Information',
        loading: 'Loading...',
        no_data: 'No data available',
        confirm_delete: 'Are you sure you want to delete this item?',
        saved_successfully: 'Saved successfully',
        saved: 'Saved successfully',
        deleted_successfully: 'Deleted successfully',
        deleted: 'Deleted successfully',
        updated: 'Updated successfully',
        created: 'Created successfully'
    },

    // Common
    common: {
        action: 'Action',
        actions: 'Actions',
        select_month: 'Select Month',
        welcome: 'Welcome',
        home: 'Home',
        back: 'Back',
        next: 'Next',
        previous: 'Previous',
        close: 'Close',
        open: 'Open',
        yes: 'Yes',
        no: 'No',
        ok: 'OK',
        all: 'All',
        none: 'None',
        total: 'Total',
        subtotal: 'Subtotal',
        tax: 'Tax',
        discount: 'Discount',
        grand_total: 'Grand Total',
        apply_filters: 'Apply filters',
        unknown: 'Unknown'
    },

    // POS
    pos: {
        search_products: 'Search products...',
        cart: 'Cart',
        clear: 'Clear',
        subtotal: 'Subtotal',
        sales_tax: 'Sales Tax',
        discount: 'Discount',
        custom_discount: 'Custom Discount',
        total: 'Total',
        select_customer: 'Select Customer',
        pay: 'Pay',
        enter_paid_amount: 'Enter paid amount',
        pay_and_print: 'Pay & Print'
    },

    // Order
    order: {
        orders: 'Orders',
        order: 'Order',
        create_order: 'Create Order',
        summary: 'Summary',
        sub_total: 'Sub Total',
        tax: 'Tax',
        discount: 'Discount',
        total: 'Total',
        pay_due: 'Pay Due',
        settle: 'Settle',
        paid: 'Paid',
        partial_paid: 'Partial Paid',
        over_paid: 'Over Paid',
        unpaid: 'Unpaid',
        settled: 'Settled',
        order_items: 'Order Items',
        order_items_count: 'Order Items ({count})',
        product_name: 'Product Name',
        product_number: 'Product Number',
        product_code: 'Product Code',
        buying: 'Buying',
        selling: 'Selling',
        enter_paid_amount: 'Enter paid amount',
        due_settlement: 'Due Settlement',
        yes_settle_it: 'Yes, settle it!',
        confirm_settle_due: 'Are you sure you want to settle the due amount?',
        due_discount_note: 'The due amount will be applied as discount.',
        settle_confirm: 'Yes, settle it!',
        settle_note: 'Note: The due amount will be applied as discount.'
    },

    // Customer
    customer: {
        customers: 'Customers',
        customer: 'Customer',
        create_customer: 'Create Customer',
        edit_customer: 'Edit Customer',
        delete_customer: 'Delete Customer',
        enter_name: 'Enter name',
        enter_email: 'Enter email',
        enter_phone: 'Enter phone',
        enter_address: 'Enter address',
        select_photo: 'Select a photo',
        confirm_delete_customer: 'Are you sure you want to delete this customer?',
        confirm_delete_button: 'Yes, delete it!'
    },

    // Supplier
    supplier: {
        suppliers: 'Suppliers',
        create_supplier: 'Create Supplier',
        edit_supplier: 'Edit Supplier',
        shop_name: 'Shop Name',
        enter_name: 'Enter supplier name',
        enter_email: 'Enter supplier email',
        enter_phone: 'Enter supplier phone',
        enter_shop_name: 'Enter shop name',
        enter_address: 'Enter supplier address',
        select_photo: 'Select a photo',
        confirm_delete_supplier: 'Are you sure you want to delete this supplier?',
        confirm_delete_button: 'Yes, delete it!'
    },

    // Expense
    expense: {
        expenses: 'Expenses',
        create_expense: 'Create Expense',
        edit_expense: 'Edit Expense',
        amount: 'Amount',
        expense_date: 'Expense Date',
        enter_amount: 'Enter amount',
        enter_expense_date: 'Enter expense date',
        delete_confirmation: 'Are you sure you want to delete this expense?',
    },

    // User
    user: {
        users: 'Users',
        email_verified_at: 'Email Verified At',
        verified: 'Verified',
        unverified: 'Unverified',
    },

    // Inventory Management
    inventory: {
        stock: 'Stock',
        product_number: 'Product Number',
        product_code: 'Product Code',
        low_stock: 'Low Stock',
        out_of_stock: 'Out of Stock',
        stock_out: 'Stock Out',
        in_stock: 'In Stock',
        stock_level: 'Stock Level',
        reorder_level: 'Reorder Level',
        supplier: 'Supplier',
        category: 'Category',
        unit: 'Unit',
        unit_price: 'Unit Price',
        selling_price: 'Selling Price',
        cost_price: 'Cost Price',
        barcode: 'Barcode',
        sku: 'SKU',
        brand: 'Brand',
        model: 'Model',
        warranty: 'Warranty',
        create_product: 'Create Product',
        edit_product: 'Edit Product',
        product_image: 'Product Image',
        filter_by_category: 'Filter by Category',
        confirm_delete_product: 'Are you sure you want to delete this product?'
    },

    // Authentication
    auth: {
        login: 'Login',
        register: 'Register',
        logout: 'Logout',
        forgot_password: 'Forgot Password',
        reset_password: 'Reset Password',
        remember_me: 'Remember Me',
        email_address: 'Email Address',
        password: 'Password',
        confirm_password: 'Confirm Password',
        sign_in: 'Sign In',
        sign_up: 'Sign Up',
        create_account: 'Create New Account',
        already_have_account: 'Already have an account?',
        dont_have_account: "Don't have an account?",
        sign_in_with_credentials: 'Sign in with credentials',
        sign_in_to_account: 'Sign in to your account',
        enter_email: 'Enter email',
        enter_password: 'Enter password',
        enter_name: 'Enter name',
        enter_confirm_password: 'Enter confirm password',
        already_registered: 'Already registered?'
    },

    // Category
    category: {
        create_category: 'Create Category',
        edit_category: 'Edit Category',
        enter_name: 'Enter name',
        confirm_delete_category: 'Are you sure you want to delete this category?',
        confirm_delete_button: 'Yes, delete it!'
    },

    // Product
    product: {
        create_product: 'Create Product',
        edit_product: 'Edit Product',
        select_category: 'Select Category',
        select_supplier: 'Select Supplier',
        select_unit_type: 'Select Unit Type',
        product_code: 'Product Code',
        root: 'Root',
        buying_date: 'Buying Date',
        buying_price: 'Buying Price',
        selling_price: 'Selling Price',
        upload_photo: 'Upload Photo',
        enter_name: 'Enter name',
        enter_product_code: 'Enter product code',
        enter_root: 'Enter root',
        enter_buying_date: 'Enter buying date',
        enter_buying_price: 'Enter buying price',
        enter_selling_price: 'Enter selling price',
        enter_quantity: 'Enter quantity',
        enter_description: 'Enter description'
    },

    // Employee
    employee: {
        employees: 'Employees',
        create_employee: 'Create Employee',
        edit_employee: 'Edit Employee',
        employee_name: 'Employee Name',
        designation: 'Designation',
        salary: 'Salary',
        joining_date: 'Joining Date',
        nid: 'NID',
        select_photo: 'Select a photo',
        enter_name: 'Enter name',
        enter_email: 'Enter email',
        enter_phone: 'Enter phone',
        enter_nid: 'Enter NID',
        enter_designation: 'Enter designation',
        enter_salary: 'Enter salary',
        enter_joining_date: 'Enter joining date',
        enter_address: 'Enter address',
        confirm_delete_employee: 'Are you sure you want to delete this employee?',
        confirm_delete_button: 'Yes, delete it!'
    },

    // Profile
    profile: {
        my_account: 'My Account',
        user_information: 'User Information',
        update_password: 'Update Password',
        current_password: 'Current Password',
        new_password: 'New Password',
        confirm_password: 'Confirm Password',
        system_settings: 'System Settings',
        email_unverified: 'Your email address is unverified.',
        resend_verification: 'Click here to re-send the verification email.',
        verification_link_sent: 'A new verification link has been sent to your email address.',
        delete_account: 'Delete Account',
        delete_account_description: 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        confirm_delete_account: 'Are you sure you want to delete your account?',
        delete_account_warning: 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.'
    },

    // Placeholders
    placeholders: {
        enter_name: 'Enter name',
        enter_description: 'Enter description',
        select_option: 'Select option',
        sample_range: 'Sample range: 10-100',
        search: 'Search',
        enter_email: 'Enter email',
        enter_order_number: 'Enter order number',
        select_customer: 'Select customer',
        enter_sub_total: 'Enter sub total',
        enter_due: 'Enter due',
        enter_profit: 'Enter profit',
        enter_loss: 'Enter loss',
        select_status: 'Select status',
        sort_by: 'Sort By',
        select_sort_field: 'Select a sort field',
        sort_order: 'Sort order',
        select_sort_order: 'Select a sort order',
        enter_created_at: 'Enter created at',
        enter_keyword: 'Enter keyword',
        enter_product_number: 'Enter product number',
        enter_product_code: 'Enter product code',
        select_category: 'Select category',
        select_supplier: 'Select supplier',
        enter_buying_price: 'Enter buying price',
        enter_selling_price: 'Enter selling price',
        enter_buying_date: 'Enter buying date',
        select_unit_type: 'Select unit type',
        enter_quantity_range: 'Enter range like: 10-100'
    },

    // Success Messages
    success_messages: {
        supplier_created: 'Supplier created successfully',
        supplier_updated: 'Supplier updated successfully',
        supplier_deleted: 'Supplier deleted successfully',
        category_created: 'Category created successfully',
        category_updated: 'Category updated successfully',
        category_deleted: 'Category deleted successfully',
        product_created: 'Product created successfully',
        product_updated: 'Product updated successfully',
        product_deleted: 'Product deleted successfully',
        product_added_to_cart: 'Product added to cart',
        cart_updated: 'Cart updated successfully',
        cart_cleared: 'Cart cleared successfully',
        order_placed: 'Order placed successfully',
        order_settled: 'Order settled successfully',
        payment_added: 'Payment added successfully',
        unit_type_created: 'Unit type created successfully',
        unit_type_updated: 'Unit type updated successfully',
        unit_type_deleted: 'Unit type deleted successfully',
        customer_created: 'Customer created successfully',
        customer_updated: 'Customer updated successfully',
        customer_deleted: 'Customer deleted successfully',
        employee_created: 'Employee created successfully',
        employee_updated: 'Employee updated successfully',
        employee_deleted: 'Employee deleted successfully',
        expense_created: 'Expense created successfully',
        expense_updated: 'Expense updated successfully',
        expense_deleted: 'Expense deleted successfully',
        salary_created: 'Salary created successfully',
        salary_updated: 'Salary updated successfully',
        salary_deleted: 'Salary deleted successfully',
        transaction_created: 'Transaction created successfully',
        transaction_updated: 'Transaction updated successfully',
        transaction_deleted: 'Transaction deleted successfully',
        contact_sent: 'Contact message sent successfully',
        settings_updated: 'Settings updated successfully',
        profile_updated: 'Profile updated successfully',
        profile_image_uploaded: 'Profile image uploaded successfully'
    },

    // Error Messages
    error_messages: {
        category_creation_failed: 'Category creation failed!',
        category_update_failed: 'Category update failed!',
        category_deletion_failed: 'Category deletion failed!',
        settings_update_failed: 'Settings update failed!',
        product_creation_failed: 'Product creation failed!',
        product_update_failed: 'Product update failed!',
        product_deletion_failed: 'Product deletion failed!',
        unit_type_creation_failed: 'Unit type creation failed!',
        unit_type_update_failed: 'Unit type update failed!',
        unit_type_deletion_failed: 'Unit type deletion failed!',
        order_place_failed: 'Failed to place order!',
        order_settlement_failed: 'Order settlement failed!',
        order_payment_failed: 'Order payment failed!',
        cart_add_product_failed: 'Failed to add product to cart!',
        cart_update_quantity_failed: 'Failed to update quantity!',
        cart_increment_quantity_failed: 'Failed to increment quantity!',
        cart_decrement_quantity_failed: 'Failed to decrement quantity!',
        cart_delete_item_failed: 'Failed to delete cart item!',
        cart_delete_all_items_failed: 'Failed to delete cart all items!',
        employee_creation_failed: 'Employee creation failed!',
        employee_update_failed: 'Employee update failed!',
        employee_deletion_failed: 'Employee deletion failed!',
        expense_creation_failed: 'Expense creation failed!',
        expense_update_failed: 'Expense update failed!',
        expense_deletion_failed: 'Expense deletion failed!',
        supplier_creation_failed: 'Supplier creation failed!',
        supplier_update_failed: 'Supplier update failed!',
        supplier_deletion_failed: 'Supplier deletion failed!',
        profile_image_upload_failed: 'Profile image upload failed!',
        salary_creation_failed: 'Salary creation failed!',
        salary_update_failed: 'Salary update failed!',
        salary_deletion_failed: 'Salary deletion failed!',
        customer_creation_failed: 'Customer creation failed!',
        customer_update_failed: 'Customer update failed!',
        customer_deletion_failed: 'Customer deletion failed!',
        transaction_creation_failed: 'Transaction creation failed!',
        transaction_update_failed: 'Transaction update failed!',
        transaction_deletion_failed: 'Transaction deletion failed!',
        contact_send_failed: 'Failed to send contact message!',
        profile_update_failed: 'Profile update failed!',
        message_send_failed: 'Message sent failed!'
    }
}