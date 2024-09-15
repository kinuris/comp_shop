# Important Notes

# Usage

```
$ composer install
$ php artisan storage:link
$ php artisan migrate --seed
$ php artisan serve
```
Admin Account:
Company ID: HP-1177
Password: password

Admin Capabilities:
- Viewing Statistics (Homepage)
    - Sales By Product
    - Sales By Category
- Employee Management (Employees Tab)
    - View Transaction History
      - Product Changes (On Manager & Admin Accounts)
      - Transactions (On Employee Accounts)
    - Account Creation
    - Account Suspension

- Product Discount Management (Discounts Tab)
    - Create Discount
    - Update Discount
    - Disable Discount

- Product Management (Products Tab)
    - Create Product
    - Update Product
    - Suspend Product
    - Restock Product
  
- Change Password

Manager Account: 
Company ID: HP-0358
Password: 1234567890

- Product Management (Products Tab)
  - _(Same as admin capabilities)_
- Change Password

Employee Account:
Company ID: HP-0959
Password: 1234567890

- Order Processing (Process Orders Tab)
    - Add product to cart
    - Checkout
    - Generate Receipt
    - Print Receipt
- View History (History Tab)
- Change Password