
# Projeto PHP Puro

Este projeto é uma aplicação PHP pura que utiliza o Composer para gerenciar dependências e o Eloquent ORM para interações com o banco de dados MySQL. A estrutura do projeto é organizada em diretórios para facilitar a manutenção e o desenvolvimento.

## Estrutura do Projeto

```plaintext
project-root/
│
├── backend/
│   ├── Controllers/
│   │   ├── UserController.php
│   │   ├── OrderController.php
│   │   └── AuthController.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   └── Order.php
│   │
│   ├── Services/
│   │   ├── UserService.php
│   │   └── OrderService.php
│   │   └── AuthService.php
│   │
│   ├── Database/
│   │   ├── Migrations/
│   │   │   ├── migrate.php
│   │   │   
│   │   └── Database.php
│   ├── tests/
│   │   ├── OrderTest.php
│   │   └── UserTest.php
│   │   
│   │
│   ├── api.php
│   └── index.php
│
└── docker-compose.yml
```

## Comandos para subir o projeto

```plaintext
make -f build.mk build
docker compose exec app php Database/Migrations/migrate.php
make -f build.mk test
```
## Usuário Admin

email: admin@example.com
password: adminpassword

## Proximos passos

* Validação da autenticação para acessar as rotas do front

* Validação dos dados enviados nas rotas

* Mostrar somente as ordens pertencentes ao usuário logado

* Criptografar os dados sensiveis dos usuários

* Filtros no front e no back com relação as ordens e usuários.

* Paginação de usuários e ordens.

* Front mais bem estruturado

## Decisões

* Para ser mais rápido utilizei o vue no front para criar a aplicação.

* No back utilizei somente o ORM e criei um middleware mais simples, acredito que há outras libs mais seguras para autenticação e segurança.



