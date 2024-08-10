docker-compose build

docker-compose up -d

docker-compose exec app bash


php src/Database/Migrations/CreateOrdersTable.php


project-root/
│
├── src/
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
│   │
│   ├── Database/
│   │   ├── Migrations/
│   │   │   ├── CreateUsersTable.php
│   │   │   └── CreateOrdersTable.php
│   │   └── Database.php
│   │
│   ├── api.php
│   └── index.php
│
└── docker-compose.yml
