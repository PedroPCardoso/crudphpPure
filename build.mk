.PHONY: build up bash install autoload migrate test

build:
	docker compose down                                       
	docker compose up --build -d
	docker compose exec app composer install
	docker compose exec app composer dump-autoload --optimize
	cd ifood && npm install && npm run dev
test:
	docker compose exec app ./vendor/bin/phpunit
