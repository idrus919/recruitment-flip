# recruitment-flip
Mini project (Restful API) for the recruit process in the flip

### How to run the application?
- open the folder of this project in the command line, then type `php migrate.php` to migration database and tables.
- to run this application, please type `php -S localhost:919` on command line.

# API Documentation

## Authentication
This token app:
`HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41`.

## General
Base url for all request is:
`http://localhost:919`

## Disbursement

### Request
```http
POST /disburse/transaction HTTP/1.1
Content-Type: application/x-www-form-urlencoded
Authorization: basic [this token app]
```
Attribute:
- `bank_code`
- `account_number`
- `amount`
- `remark`

### Response

```json
Status 200
Content-Type: application/json
{
    "id": "id",
    "amount": "amount",
    "status": "status",
    "timestamp": "timestamp",
    "bank_code": "bank_code",
    "account_number": "account_number",
    "beneficiary_name": "beneficiary_name",
    "remark": "remark",
    "receipt": "receipt",
    "time_served": "time_served",
    "fee": "fee"
}
```

## Disbursement Status
This endpoint when receiving feedback from a disbursement has been processed

### Request
```http
PUT /disburse/transaction/{transaction_id} HTTP/1.1
Content-Type: application/x-www-form-urlencoded
Authorization: basic [this token app]
```
Attribute:
- `status`
- `receipt`

### Response
```json
Status 200
Content-Type: application/json
{
    "id": "id",
    "amount": "amount",
    "status": "status",
    "timestamp": "timestamp",
    "bank_code": "bank_code",
    "account_number": "account_number",
    "beneficiary_name": "beneficiary_name",
    "remark": "remark",
    "receipt": "receipt",
    "time_served": "time_served",
    "fee": "fee"
}
```

## Disbursement Check Status

### Request
```http
GET /disburse/transaction/{transaction_id} HTTP/1.1
Content-Type: application/x-www-form-urlencoded
Authorization: basic [this token app]
```

### Response
```json
Status 200
Content-Type: application/json
{
    "id": "id",
    "amount": "amount",
    "status": "status",
    "timestamp": "timestamp",
    "bank_code": "bank_code",
    "account_number": "account_number",
    "beneficiary_name": "beneficiary_name",
    "remark": "remark",
    "receipt": "receipt",
    "time_served": "time_served",
    "fee": "fee"
}
```