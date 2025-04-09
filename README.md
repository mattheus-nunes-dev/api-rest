## 📋 Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/) instalado.
- Git (opcional, para clonar o repositório).

## 🛠 Configuração Inicial

Clone o repositório

```
git clone https://github.com/mattheus-nunes-dev/api-rest.git
cd api-rest
```
Clone o arquivo env

```
cp .env.example .env
```

Instale as dependências

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

Suba os containers

```
./vendor/bin/sail up -d
```

Gere a APP_KEY usando o Sail

```
./vendor/bin/sail art key:generate
```

Execute as migrations e seeder

```
./vendor/bin/sail art migrate --seed
```

Acesse o Console Web do MinIO em:
🔗 http://localhost:9001

    Login: sail | Senha: password

    Crie um bucket chamado laravel (ou o nome definido em AWS_BUCKET).
    

## 🌐 Acesso aos Serviços

Realizar autenticação - Postman ou cURL

```
#Método HTTP: POST

curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@admin.com",
    "password": "12345678"
  }'

```

Renovar autenticação

```
#Método HTTP: POST

curl -X POST http://localhost/api/renovar-token \
  -H "Content-Type: application/json" \
  -d '{
    "token": "TOKEN_ATUAL"
  }'

```

Cadastrar Cidades

```
#Método HTTP: POST

curl -X POST http://localhost/api/cidades \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "cid_nome": "Jangada",
    "cid_uf": "MT"
  }'

```

Listar Cidades

```
#Método HTTP: GET

curl -X GET http://localhost/api/cidades \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Visualizar Cidade - Passar o parametro

```
#Método HTTP: GET

curl -X GET http://localhost/api/cidades/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Atualizar Cidade

```
#Método HTTP: PUT

curl -X PUT http://localhost/api/cidades/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "cid_nome": "Jangada2",
    "cid_uf": "MT"
  }'

```

Deletar Cidade

```
#Método HTTP: DELETE

curl -X DELETE http://localhost/api/cidades/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

