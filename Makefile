deploy_dev:
	docker-compose up -d api-transacoes_dev
	make install

install:
	docker exec api-transacoes composer install

down:
	docker-compose -f ./docker/docker-compose.yaml down
