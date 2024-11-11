___
[Home](../README.md) |
[Requisitos](./Onfly-Teste-Tecnico.md) |
[Endpoints](./Endpoints.md) |
[Tests](./ListTests.md) |
[Querys](./Querys.md) |
___

## Querys

#### Users
```sql
insert into users (superuser, user_name, email, created_at, updated_at)
values
(1, 'Root Onfly', 'root@onfly.com', now(), now()),
(0, 'User Onfly', 'user@onfly.com', now(), now());
```

#### Cards
```sql
insert into cards
(id, fk_user, card_number, balance, balance_created, deleted, created_at, updated_at)
values
(1, 1, '1111222233334444', 1000.00, 1000.00, 0, '2024-11-08 00:00:00', '2024-11-11 04:40:08'),
(2, 2, '1234123412341234', 1000.00, 1000.00, 0, '2024-11-08 00:00:00', '2024-11-11 04:40:08');
```

#### Expenses
```sql
```
