# Database Relationships Documentation

## ✅ YES! All relationships are properly implemented in MySQL with foreign keys

## 📊 Database Structure & Relationships

### **1. Customers → Orders** (One-to-Many)
- **Relationship**: One customer can have MANY orders
- **Foreign Key**: `orders.customer_id` → `customers.id`
- **MySQL Constraint**: `FOREIGN KEY (customer_id) REFERENCES customers(id)`
- **On Delete**: CASCADE (when customer is deleted, all their orders are deleted)

```sql
-- In orders table:
customer_id BIGINT UNSIGNED
FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
```

### **2. Orders → Order Details** (One-to-Many)
- **Relationship**: One order can have MANY order details (line items)
- **Foreign Key**: `order_details.order_id` → `orders.id`
- **MySQL Constraint**: `FOREIGN KEY (order_id) REFERENCES orders(id)`
- **On Delete**: CASCADE (when order is deleted, all order details are deleted)

```sql
-- In order_details table:
order_id BIGINT UNSIGNED
FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
```

### **3. Products → Order Details** (One-to-Many)
- **Relationship**: One product can be in MANY order details
- **Foreign Key**: `order_details.product_id` → `products.id`
- **MySQL Constraint**: `FOREIGN KEY (product_id) REFERENCES products(id)`
- **On Delete**: CASCADE (when product is deleted, related order details are deleted)

```sql
-- In order_details table:
product_id BIGINT UNSIGNED
FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
```

## 🔗 Complete Relationship Chain

```
Customer (1) ──────> Orders (Many)
                        │
                        │ (1 Order)
                        ▼
                  Order Details (Many)
                        │
                        │ (references)
                        ▼
                    Product (1)
```

## 📋 Relationship Examples

### Example 1: Customer "John Doe"
```
John Doe (customer_id: 1)
  └── Order #1 (order_id: 1)
       ├── Order Detail #1: Laptop × 1 = $1,299.99
       └── Order Detail #2: Mouse × 2 = $99.98
  └── Order #2 (order_id: 2)
       └── Order Detail #3: Keyboard × 1 = $149.99
```

### Example 2: Product "Laptop"
```
Laptop (product_id: 1)
  ├── Used in Order Detail #1 (Order #1, Customer: John)
  ├── Used in Order Detail #5 (Order #3, Customer: Jane)
  └── Used in Order Detail #8 (Order #5, Customer: Mike)
```

## 🔍 How to Verify Relationships in MySQL

### Check Foreign Keys in MySQL:
```sql
-- Show all foreign keys in orders table
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_NAME = 'orders' 
AND TABLE_SCHEMA = 'crud1'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Show all foreign keys in order_details table
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_NAME = 'order_details' 
AND TABLE_SCHEMA = 'crud1'
AND REFERENCED_TABLE_NAME IS NOT NULL;
```

## 💡 Eloquent Relationships (in Laravel Models)

### Customer Model
```php
public function orders()
{
    return $this->hasMany(Order::class);
}
```

### Order Model
```php
public function customer()
{
    return $this->belongsTo(Customer::class);
}

public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}
```

### Product Model
```php
public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}
```

### OrderDetail Model
```php
public function order()
{
    return $this->belongsTo(Order::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
```

## ✅ Relationship Rules Enforced

### 1. **Referential Integrity**
- ✅ Cannot create an order without a valid customer
- ✅ Cannot create order detail without valid order and product
- ✅ Cannot delete a customer if they have orders (will cascade delete)

### 2. **Cascade Deletes**
```
Delete Customer → Automatically deletes all their Orders
                → Which automatically deletes all Order Details

Delete Order → Automatically deletes all Order Details

Delete Product → Automatically deletes related Order Details
```

### 3. **Data Consistency**
- Every order MUST have exactly ONE customer
- Every order detail MUST have exactly ONE order
- Every order detail MUST have exactly ONE product
- One customer can have 0 or MANY orders
- One order can have 1 or MANY order details
- One product can be in 0 or MANY order details

## 🧪 Test the Relationships

### In MySQL:
```sql
-- View orders with customer names
SELECT 
    orders.id,
    customers.name,
    orders.order_date,
    orders.total_amount
FROM orders
JOIN customers ON orders.customer_id = customers.id;

-- View order details with product info
SELECT 
    order_details.id,
    orders.id as order_number,
    products.name as product_name,
    order_details.quantity,
    order_details.subtotal
FROM order_details
JOIN orders ON order_details.order_id = orders.id
JOIN products ON order_details.product_id = products.id;

-- View complete order information
SELECT 
    customers.name as customer_name,
    orders.id as order_id,
    products.name as product_name,
    order_details.quantity,
    order_details.subtotal
FROM customers
JOIN orders ON customers.id = orders.customer_id
JOIN order_details ON orders.id = order_details.order_id
JOIN products ON order_details.product_id = products.id;
```

### In Laravel (Eloquent):
```php
// Get customer with all orders
$customer = Customer::with('orders')->find(1);

// Get order with customer and order details
$order = Order::with(['customer', 'orderDetails.product'])->find(1);

// Get product with all order details
$product = Product::with('orderDetails.order.customer')->find(1);
```

## 🎯 Summary

✅ **All relationships are FULLY implemented in MySQL**
- Foreign key constraints are created
- Cascading deletes are active
- Referential integrity is enforced
- Both MySQL and Laravel Eloquent relationships work together

✅ **Database is properly normalized**
- No data duplication
- Relationships are clearly defined
- Data integrity is maintained

✅ **Relationships are ACTIVELY USED in the application**
- Customer views show their orders
- Order views show customer info and products
- Product deletion updates stock properly
- Order deletion restores product stock

**Your database has proper relational structure with all foreign keys and constraints working perfectly!** 🎉
