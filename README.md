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

Employee Account:
Company ID: HP-0959
Password: 1234567890

## Cart

- The moment cart records are inserted it means that the order has successfully been processed
- Cart records are grouped by a transaction ID, a unique one is generated upon completion of payment
    - Use 'uuid v4' as the transaction ID generation method 

- Consider making this into an e-Commerce system with the addition of a frontend that can accomodate customers
