deploy:
	docker-compose up -d
	make install
	docker exec api-transacoes php artisan migrate
	docker exec api-transacoes php artisan queue:work

install:
	docker exec api-transacoes composer install

down:
	docker-compose -f ./docker/docker-compose.yaml down

teste:
    docker exec api-transacoes ./vendor/bin/pest

