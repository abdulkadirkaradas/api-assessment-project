# Instructions

### Running Docker

- Runnning container and images;
- `docker-exec build`
- `docker compose up -d`
 
### Running Database Tables and Dummy Values

- `docker-compose exec app php artisan migrate --seed`

### Running Key and Link Commands

- `docker-compose exec app php artisan key:generate`
- `docker-compose exec app php artisan storage:link`

# API Routes

**API Url:** http://127.0.0.1:8080/api/v1[ROUTE_URI]

### `api/v1/orders`
- **Method:** GET, HEAD
- **Name:** N/A
- **Middleware:** api
- **Description:** This API route lists all order records

### `api/v1/orders`
- **Method:** POST
- **Name:** N/A
- **Middleware:** api
- **Description:** This API route This API route is used to add a new Order.
- **Example;**
```
# The request body should be like the example below
{
    "order": [
        {
            "productId": 1,
            "quantity": 2
        },
        {
            "productId": 2,
            "quantity": 2
        },
        {
            "productId": 3,
            "quantity": 5
        }
    ],
    "customerId": 2
}
```

### `api/v1/order/{id}`
- **Method:** DELETE
- **Name:** N/A
- **Middleware:** api
- **Description:** This API route deletes the Order with the specified id.
  
### `api/v1/calculate-discount/order/{id}`
- **Method:** GET, HEAD
- **Name:** N/A
- **Middleware:** api
- **Description:** This API route calculates and returns discounts for Orders with the specified id.