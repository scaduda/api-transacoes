deploy_dev:
	docker-compose up -d --build
	docker exec api-transacoes composer install
	docker exec api-transacoes php artisan migrate
	docker exec api-transacoes php artisan queue:work
down:
	docker-compose down --remove-orphans
test:
	docker exec api-transacoes php artisan test
generate-scribe:
	docker exec api-transacoes php artisan scribe:generate
