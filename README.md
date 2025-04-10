## 🚀 Informações do processo seletivo
Processo Seletivo:
    PSS 02/2025/SEPLAG (Analista de TI - Perfil Junior, Pleno e Sênior)
Inscrição:
    10003
Nome:
    MATTHEUS NUNES ARAÚJO

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

Cadastrar Unidade

```
#Método HTTP: POST

curl -X POST http://localhost/api/unidades \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "unid_nome": "Secretaria de Educação",
    "unid_sigla": "seduc",
    "end_tipo_logradouro": "Comercial",
    "end_logradouro": "R. Eng. Edgar Prado Arze",
    "end_numero": "01",
    "end_bairro": "Centro Político Administrativo",
    "cid_id": "1"
  }'

```

Listar Unidades

```
#Método HTTP: GET

curl -X GET http://localhost/api/unidades \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Visualizar Unidade - Passar o parametro

```
#Método HTTP: GET

curl -X GET http://localhost/api/unidades/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Atualizar Unidade

```
#Método HTTP: PUT

curl -X PUT http://localhost/api/unidades/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "unid_nome": "Secretaria de Educação2",
    "unid_sigla": "seduc",
    "end_tipo_logradouro": "Comercial",
    "end_logradouro": "R. Eng. Edgar Prado Arze",
    "end_numero": "01",
    "end_bairro": "Centro Político Administrativo",
    "cid_id": "1"
  }'

```

Deletar Unidade

```
#Método HTTP: DELETE

curl -X DELETE http://localhost/api/unidades/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Cadastrar Servidor Efetivo

```
#Método HTTP: POST

curl -X POST http://localhost/api/servidor-efetivos \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "pes_nome": "Juliana Lara",
    "pes_data_nascimento": "1995-02-10",
    "pes_sexo": "M",
    "pes_mae": "Marta Lara",
    "pes_pai": "Rui Lara",
    "end_tipo_logradouro": "Residencial",
    "end_logradouro": "Rua Dezesseis",
    "end_numero": "254",
    "end_bairro": "Bela Vista",
    "cid_id": "1",
    "se_matricula": "654123",
    "unid_id": "1",
    "lot_data_lotacao": "2024-01-02",
    "lot_data_remocao": "2040-01-10",
    "lot_portaria": "portaria2"
  }'

```

Listar Servidores Efetivos

```
#Método HTTP: GET

curl -X GET http://localhost/api/servidor-efetivos \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Visualizar Servidor Efetivo - Passar o parametro

```
#Método HTTP: GET

curl -X GET http://localhost/api/servidor-efetivos/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Atualizar Servidor Efetivo

```
#Método HTTP: PUT

curl -X PUT http://localhost/api/servidor-efetivos/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "pes_nome": "Juliana Lara 2",
    "pes_data_nascimento": "1995-02-10",
    "pes_sexo": "M",
    "pes_mae": "Marta Lara",
    "pes_pai": "Rui Lara",
    "end_tipo_logradouro": "Residencial",
    "end_logradouro": "Rua Dezesseis",
    "end_numero": "254",
    "end_bairro": "Bela Vista",
    "cid_id": "1",
    "se_matricula": "654123",
    "unid_id": "1",
    "lot_data_lotacao": "2024-01-02",
    "lot_data_remocao": "2040-01-10",
    "lot_portaria": "portaria2"
  }'

```

Deletar Servidor Efetivo

```
#Método HTTP: DELETE

curl -X DELETE http://localhost/api/servidor-efetivos/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Consultar os servidores efetivos lotados em determinada unidade parametrizando a consulta pelo atributo unid_id

```
#Método HTTP: GET

curl -X GET http://localhost/api/servidor-efetivos-unidade/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Consultar o endereço funcional (da unidade onde o servidor é lotado) a partir de uma parte do nome do servidor efetivo

```
#Método HTTP: GET

curl -X GET http://localhost/api/servidor-efetivos-unidade/juli \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Cadastrar Servidor Temporário

```
#Método HTTP: POST

curl -X POST http://localhost/api/servidor-temporarios \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "pes_nome": "Gustavo Silva",
    "pes_data_nascimento": "1991-05-02",
    "pes_sexo": "M",
    "pes_mae": "Celia Silva",
    "pes_pai": "Ceni Silva",
    "end_tipo_logradouro": "Residencial",
    "end_logradouro": "Rua Dezesseis",
    "end_numero": "254",
    "end_bairro": "Bela Vista",
    "cid_id": "1",
    "sf_data_admissao": "2024-02-04",
    "sf_data_demissao": "2026-02-04",
    "unid_id": "1",
    "lot_data_lotacao": "2022-02-04",
    "lot_data_remocao": "2040-02-04",
    "lot_portaria": "portaria"
  }'

```

Listar Servidores Temporários

```
#Método HTTP: GET

curl -X GET http://localhost/api/servidor-temporarios \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Visualizar Servidor Temporário - Passar o parametro

```
#Método HTTP: GET

curl -X GET http://localhost/api/servidor-temporarios/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Atualizar Servidor Temporário

```
#Método HTTP: PUT

curl -X PUT http://localhost/api/servidor-temporarios/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "pes_nome": "Gustavo Silva 2",
    "pes_data_nascimento": "1991-05-02",
    "pes_sexo": "M",
    "pes_mae": "Celia Silva",
    "pes_pai": "Ceni Silva",
    "end_tipo_logradouro": "Residencial",
    "end_logradouro": "Rua Dezesseis",
    "end_numero": "254",
    "end_bairro": "Bela Vista",
    "cid_id": "1",
    "sf_data_admissao": "2024-02-04",
    "sf_data_demissao": "2026-02-04",
    "unid_id": "1",
    "lot_data_lotacao": "2022-02-04",
    "lot_data_remocao": "2040-02-04",
    "lot_portaria": "portaria"
  }'

```

Deletar Servidor Temporário

```
#Método HTTP: DELETE

curl -X DELETE http://localhost/api/servidor-temporarios/1 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \

```

Upload de uma ou mais fotografias enviando-as para o Min.IO

```
#Método HTTP: POST -- Envio de uma foto

curl -X POST http://localhost/api/upload \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: multipart/form-data" \
  -F "fotos[]=@/caminho/da/foto1.jpg" \
  -F "fotos[]=@/caminho/da/foto2.jpg"

```

```
#Método HTTP: POST -- Envio de multiplas fotos - com retorno de link temporario

curl -X POST http://localhost/api/upload-fotos \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: multipart/form-data" \
  -F "fotos[]=@/caminho/da/foto1.jpg" \
  -F "fotos[]=@/caminho/da/foto2.jpg"

```

