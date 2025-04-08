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

Gere a APP_KEY usando o Sail

```
./vendor/bin/sail art key:generate
```

Execute as migrations e seeder

```
./vendor/bin/sail art migrate --seed
```


