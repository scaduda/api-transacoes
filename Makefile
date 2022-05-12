deploy_dev:
	docker-compose up -d --build
	docker exec api-transacoes composer install
	docker exec api-transacoes php artisan migrate:fresh
	docker exec api-transacoes php artisan db:seed
	docker exec api-transacoes php artisan queue:work
down:
	docker-compose down --remove-orphans
test:
	docker exec api-transacoes php artisan test
generate-scribe:
	docker exec api-transacoes php artisan scribe:generate
