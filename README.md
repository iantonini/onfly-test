### Onfly | Teste técnico

___
[Home](./README.md) |
[Requisitos](./docs/Onfly-Teste-Tecnico.md) |
[Endpoints](./docs/Endpoints.md) |
[Tests](./docs/ListTests.md) |
[Querys](./docs/Querys.md) |
___


#### Executar projeto:
```bash
docker-compose -f docker/docker-compose.yml up -d --build
```

#### Configurações iniciais:
```bash
docker exec -it onfly_api bash
composer install --no-interaction --prefer-dist --optimize-autoloader
php bin/hyperf.php migrate
./vendor/bin/phpunit
```

#### Executar Seeders
```bash
php bin/hyperf.php db:seed
```

___
#### Link's de referência:
- Documentação [Hyperf](https://hyperf.wiki/3.1/#/en/)
