# Expenses Management System
> API para gerenciamento de despesas de funcionários


## Requerimentos

* PHP 8.1
* Laravel 10
* Mysql 8


## Instalação

1 - Rodar composer
```sh
 composer install
```

2 - Configurar .env
```sh
 Configurar infos do BD
```

3 - Rodar migrations
```sh
 php artisan migrate
```

4 - Instalar chaves da aplicação com passport
```sh
 php artisan passport:install
```


## Execução Local
Portas da API: Padrão 
APP_PORT=8000

Laravel Sail
```sh
 sail up -d
```

ou 

Docker
```sh
 docker-compose up -d
```

## Documentação
```sh
 https://documenter.getpostman.com/view/2s9Y5Tzjiy?version=latest
```
