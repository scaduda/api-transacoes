deploy_dev:
	docker-compose up -d
	make install

install:
	docker exec api-transacoes composer install

down:
	docker-compose -f ./docker/docker-compose.yaml down
