.PHONY: init
init:
	cp .env.example .env
	docker compose up -d
	sleep 20
	docker exec -it test-your-might-back-1 php artisan migrate --seed

.PHONY: install
start:
	docker compose up -d