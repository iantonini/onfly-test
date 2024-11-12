## Endpoints
Arquivo para importar no postman disponível:   
[yaml](./Postman/Postman.yaml) | [json](./Postman/Postman.json) | [har](./Postman/Postman.har)

## Login   
___
### /login   
method: POST   
body: application/json   

Request:

Request:
```json   
    {   
      "email": "root@onfly.com"   
    }   
```   

Response:
```json
{
	"status": "success",
	"message": "authorized email",
	"token": "e714737374acc3e767e149f0f0e48dfe"
}
```

## Users   
___
### /user   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "1e714737374acc3e767e149f0f0e48dfe"   
    }   
```   
Response:
```json
{
	"status": "error",
	"message": "Unable to find a user with the provided token",
	"user": null
}
```
___
### /users   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "success",
	"users": [
		{
			"id": 1,
			"superuser": 1,
			"user_name": "Root Onfly",
			"email": "root@onfly.com",
			"created_at": "2024-11-08 00:00:00",
			"updated_at": "2024-11-08 00:00:00"
		},
		{
			"id": 2,
			"superuser": 0,
			"user_name": "User Onfly",
			"email": "user@onfly.com",
			"created_at": "2024-11-08 00:00:00",
			"updated_at": "2024-11-08 00:00:00"
		}
	]
}
```
___
### /users   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "d2ec2f35e0cfb64c3262198672a770c1"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "success",
	"users": {
		"id": 2,
		"superuser": 0,
		"user_name": "User Onfly",
		"email": "user@onfly.com",
		"created_at": "2024-11-08 00:00:00",
		"updated_at": "2024-11-08 00:00:00"
	}
}
```
___
### /user/create   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "user_name": "User One Onfly",   
      "superuser": false,   
      "email": "1234@onfly.com"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "user created successfully",
	"user": {
		"user_name": "User1 Onfly",
		"superuser": false,
		"email": "user1@onfly.com",
		"updated_at": "2024-11-11 04:04:35",
		"created_at": "2024-11-11 04:04:35",
		"id": 3
	}
}
```
___
### /user/update   
method: PUT   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "user_name": "User Onfly",   
      "superuser": false,   
      "email": "user@onfly.com",   
      "new_email": ""   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "user updated successfully",
	"user": {
		"id": 2,
		"superuser": 0,
		"user_name": "User Onfly",
		"email": "user@onfly.com",
		"created_at": "2024-11-08 00:00:00",
		"updated_at": "2024-11-10 00:00:00"
	}
}
```
___
### /user/delete   
method: DELETE   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "email": "user1@onfly.com"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "user deleted successfully",
	"user": null
}
```

## Cards   
___
### /cards/user   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "success",
	"cards": [
		{
			"id": 1,
			"fk_user": 1,
			"card_number": "1111222233334444",
			"balance": "1000.00",
			"balance_created": "1000.00",
			"deleted": 0,
			"created_at": "2024-11-08 00:00:00",
			"updated_at": "2024-11-08 00:00:00"
		}
	]
}
```
___
### /cards   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "success",
	"cards": [
		{
			"id": 1,
			"fk_user": 1,
			"card_number": "1111222233334444",
			"balance": "1000.00",
			"balance_created": "1000.00",
			"deleted": 0,
			"created_at": "2024-11-08 00:00:00",
			"updated_at": "2024-11-08 00:00:00"
		},
		{
			"id": 2,
			"fk_user": 2,
			"card_number": "5555666677778888",
			"balance": "1000.00",
			"balance_created": "1000.00",
			"deleted": 0,
			"created_at": "2024-11-08 00:00:00",
			"updated_at": "2024-11-08 00:00:00"
		}
	]
}
```
___
### /card/create   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "user_id": 1,   
      "balance": 1000.00   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "card created successfully",
	"card": {
		"fk_user": 1,
		"card_number": "3582367425329775",
		"balance": 1000,
		"balance_created": 1000,
		"updated_at": "2024-11-08 00:00:00",
		"created_at": "2024-11-08 00:00:00",
		"id": 6
	}
}
```
___
### /cards/deleted   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "Card deleted successfully",
	"card": {
		"id": 2,
		"fk_user": 2,
		"card_number": "5555666677778888",
		"balance": "1000.00",
		"balance_created": "1000.00",
		"deleted": 1,
		"created_at": "2024-11-08 00:00:00",
		"updated_at": "2024-11-10 00:00:00"
	}
}
```
___
### /card/update   
method: PUT   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "card_number": "1111222233334444",   
      "new_balance": 100,   
      "new_user_id": 1   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "Card updated successfully",
	"card": {
		"id": 1,
		"fk_user": 1,
		"card_number": "1111222233334444",
		"balance": "100.00",
		"balance_created": "1000.00",
		"deleted": 0,
		"created_at": "2024-11-08 00:00:00",
		"updated_at": "2024-11-10 00:00:00"
	}
}
```
___
### /card/delete   
method: DELETE   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "card_number": "1111222233334444"   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "Card deleted successfully",
	"card": {
		"id": 3,
		"fk_user": 1,
		"card_number": "1111222233334444",
		"balance": "100.00",
		"balance_created": "1000.00",
		"deleted": 1,
		"created_at": "2024-11-08 00:00:00",
		"updated_at": "2024-11-10 00:00:00"
	}
}
```

## Expenses   
___
### /expenses/card   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "card_number": "3281936096639316"   
    }   
```   

Response:
```json
{
	"status": "success",
	"message": "success",
	"card": {
		"id": 1,
		"card_number": "1111222233334444",
		"balance_created": "1000.00",
		"balance": "1000.00",
		"deleted": 0
	},
	"expenses": []
}
```
___
### /expense/create   
method: POST   
body: application/json   

Request:
```json   
    {   
      "token": "e714737374acc3e767e149f0f0e48dfe",   
      "card_number": "3281936096639316",   
      "expense_value": 5   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "success",
	"expenses": {
		"id": 1,
		"card_number": "1111222233334444",
		"expense_value": 15,
		"previous_balance": 1000,
		"current_balance": 985
	}
}
```
___
### /expense/delete   
method: DELETE   
body: application/json   

Request:
```json   
    {   
      "token": "21b3801263d1e7289db9039fffc55075",   
      "expense_id": 97   
    }   
```   
Response:
```json
{
	"status": "success",
	"message": "success",
	"expenses": {
		"id": 5,
		"expense_value": 15,
		"previous_balance": 985,
		"current_balance": 1000
	}
}
```
