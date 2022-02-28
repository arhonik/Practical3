# Docker for backend internships

1. Скопируйте репозиторий командой `git clone git@github.com:arhonik/Practical3.git`
2. Перейдите в директорию `docker` командой `cd Practical3/docker/`
3. Скопируйте файл `.env.example` в `.env` командой `cp .env.example .env`
4. Запустите docker контейнеры командой `docker-compose up -d --build`
5. Передите в образ php-fpm_1 командой `docker exec -itu1000 resolventa_backend_internship_php-fpm_1 bash`
6. Устанавливаем пакеты composer командой `composer install`
7. Выполняем миграцию командой  `./bin/console doctrine:migrations:migrate`
8. Запускаем fixture для заполнения данными `./bin/console doctrine:fixtures:load`
9. Перейдите на [страницу проекта](http://localhost/movie-shows)
