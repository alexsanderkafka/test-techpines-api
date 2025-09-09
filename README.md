# Techpines Test
- API desenvolvida em Laravel como parte de um teste técnico

# Tecnologia utilizada
- PHP 8.3.13
- Laravel 11
- Redis
- MySQL
- Docker

## DER - Diagrama de entidade relacional
![der](https://github.com/alexsanderkafka/test-techpines-api/blob/main/assets/der.png)

##

# Pré-requisitos
- Instalar todas as dependências -> composer install
- É necessário criar o arquivo .env, copie o arquivo .env.example e troque o nome do .env.example copy para .env
- Configurar o .env:

```bash
# Crie a APP_KEY -> php artisan key:generate

# Banco de dados no container
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=techpines_api
DB_USERNAME=root
DB_PASSWORD=senha

# Redis no container
REDIS_CLIENT=predis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Gmail com senha de APP
- No desenvolvimento desse teste foi utilizado o gmail
- É necessário criar uma senha de app, você pode conferir no google account: https://myaccount.google.com/u/7/apppasswords
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=SEU EMAIL COM SENHA DE APP
MAIL_PASSWORD=SENHA DE APP

# Criar a JWT_SECRET -> php artisan jwt:secret

```

## Para rodar o projeto em um container Docker e ele funcionar
- Necessário possuir o Docker instalado na sua máquina

```bash
# Criar o container docker
docker-compose up --build

# Rodar em background
docker-compose up -d --build

# Migrations
docker exec -it techpines-test-api php artisan migrate

# Teste dos endpoints
docker exec -it techpines-test-api php artisan test

```

  
