# Users API

### Pré-requisitos
- Docker [Install Docker](https://docs.docker.com/engine/install/)
- Composer [Install Composer](https://getcomposer.org/download/)
- Symfony [Install Symfony](https://symfony.com/download)

  ## Executando o Projeto

  ```bash
  git clone git@github.com:Gabriela-Amaro/users_api.git
  ```
  ```bash
  cd users_api
  ```
  ```bash
  composer install
  ```
  ```bash
  docker compose up -d
  ```
  ```bash
  symfony console doctrine:database:create --if-not-exists
  ```
  ```bash
  symfony console doctrine:migrations:migrate
  ```
  ```bash
  php bin/console cache:clear
  ```
  ```bash
  symfony server:start -d
  ```

## Endpoints

#### Busca todos 
GET ``` 127.0.0.1:8000/api/users ``` 

#### Busca específica
GET ``` 127.0.0.1:8000/api/users/{user} ``` 

#### Criação
POST ``` 127.0.0.1:8000/api/users ```

#### Atualização
PUT ``` 127.0.0.1:8000/api/users/{user} ```

#### Remoção
DELETE ``` 127.0.0.1:8000/api/users/{user} ```
