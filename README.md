# Documentação do Sistema Solar Projects

## Sumário
1. [Visão Geral](#1-visão-geral)
2. [Entidades do Sistema](#2-entidades-do-sistema)
   - User
   - Customer
   - Project
3. [Endpoints da API](#3-endpoints-da-api)
   - Autenticação
   - Customers
   - Projects
4. [Instruções de Instalação](#4-instruções-de-instalação)
5. [Instruções de Uso](#5-instruções-de-uso)

## 1. Visão Geral
O sistema Solar Projects é uma aplicação para integradores solares que permite o cadastro, visualização, atualização e exclusão de projetos de energia solar. O sistema gerencia informações sobre clientes, localização da instalação, tipo de instalação e equipamentos necessários.

## 2. Entidades do Sistema

### User
- Descrição: Representa os usuários que utilizam o sistema.
- Atributos
  - `id`: Identificador único do usuário.
  - `name`: Nome do usuário.
  - `email`:E-mail do usuário.
  - `password`: Senha do usuário (armazenada de forma segura).
  - `created_at`: Data de criação do usuário.
  - `updated_at`: Data de atualização do usuário.

### Customer
- Descrição: Representa os clientes do sistema, que são aqueles que contratam os serviços de instalação solar.
- Atributos
  - `id`: Identificador único do cliente.
  - `name`: Nome do cliente.
  - `email`: E-mail do cliente.
  - `phone`: Telefone do cliente (celular ou fixo).
  - `document`: Documento do cliente (CPF ou CNPJ).
  - `created_at`: Data de criação do cliente.
  - `updated_at`: Data de atualização do cliente.
 
### Project
- Descrição: Representa os projetos solares, que são as instalações feitas para os clientes.
- Atributos
  - `id`: Identificador único do projeto.
  - `customer_id`: Identificador do cliente associado ao projeto.
  - `location`: Localização da instalação.
  - `installation_type`: Tipo de instalação (enum: Fibrocimento, Cerâmico, Metálico, etc.).
  - `equipment`: Equipamentos utilizados na instalação (enum: Módulo, Inversor, Cabo Tronco, etc.).
  - `status`: Status do projeto (em andamento, concluído, etc.).
  - `created_at`: Data de criação do projeto.
  - `updated_at`: Data de atualização do projeto.
 
## 3. Endpoints da API

### Autenticação
- Register
   - Endpoint: `/api/register`
   - Método: `POST`
   - Descrição: Cria um novo usuário no sistema.
   - Parâmetros
      - `name` (string, obrigatório)
      - `email` (string, obrigatório)
      - `password` (string, obrigatório)
   - Resposta: Retorna um token JWT para autenticação.
- Login
   - Endpoint: `/api/login`
   - Método: `POST`
   - Descrição: Autentica o usuário no sistema.
   - Parâmetros
      - `email` (string, obrigatório)
      - `password` (string, obrigatório)
   - Resposta: Retorna um token JWT para autenticação.
- Logout
  - Endpoint `/api/logout`
  - Método `POST`
  - Descrição: Realiza o logout do usuário.

### Customers
- Listar Clientes
   - Endpoint: `/api/customers`
   - Método: `GET`
   - Descrição: Retorna uma lista de todos os clientes.
   - Resposta: JSON com a lista de clientes.
- Criar Cliente
  - Endpoint: `/api/customers`
  - Método: `POST`
  - Descrição: Cria um novo cliente.
  - Parâmetros:
    - `name` (string, obrigatório)
    - `email` (string, obrigatório)
    - `phone` (string, obrigatório)
    - `address` (string, opcional)
  - Resposta: JSON com os detalhes do cliente criado.
- Atualizar Cliente
  - Endpoint: `/api/customers/{id}`
  - Método: `PUT`
  - Descrição: Atualiza os dados de um cliente existente.
  - Parâmetros
    - `name` (string, opcional)
    - `email` (string, opcional)
    - `phone` (string, opcional)
    - `address` (string, opcional)
  - Resposta: JSON com os detalhes do cliente atualizado.
- Deletar Cliente
  - Endpoint: `/api/customers`
  - Método: `DELETE`
  - Descrição: Remove um cliente do sistema.
  - Resposta: Status de sucesso ou erro.

### Projects
- Listar Projetos
  - Endpoint: `/api/projects`
  - Método: `GET`
  - Descrição: Retorna uma lista de todos os projetos.
  - Resposta: JSON com a lista de projetos.
- Criar Projeto
  - Endpoint: `/api/projects`
  - Método: `POST`
  - Descrição: Cria um novo projeto.
  - Parâmetros:
    - `description` (enum, obrigatório)
    - `state` (enum, obrigatório)
    - `installation_type` (enum, obrigatório)
    - `customer_id` (integer, obrigatório)
  - Resposta: JSON com os detalhes do projeto criado.
- Atualizar Projeto
  - Endpoint: `/api/projects/{id}`
  - Método: `PUT`
  - Descrição: Atualiza os dados de um projeto existente.
  - Parâmetros
    - `description` (enum, opcional)
    - `state` (enum, opcional)
    - `installation_type` (enum, opcional)
    - `customer_id` (integer, opcional)
  - Resposta: JSON com os detalhes do projeto atualizado.
- Deletar Projeto
  - Endpoint: `/api/projects/{id}`
  - Método: `DELETE`
  - Descrição: Remove um projeto do sistema.
  - Resposta: Status de sucesso ou erro.
 
  
#### Equipamentos Relacionados a Projetos
- Listar Equipamentos de um Projeto
  - Endpoint: `/api/projects/{id}/equipments`
  - Método: `GET`
  - Descrição: Retorna uma lista de todos os equipamentos associados a um projeto específico.
  - Resposta: JSON com a lista de equipamentos.
- Adicionar Equipamento a um Projeto
  - Endpoint: `/api/projects/{id}/equipments`
  - Método: `POST`
  - Descrição: Adiciona um novo equipamento a um projeto específico.
  - Parâmetros:
    - `type` (enum, obrigatório)
    - `quantity` (integer, obrigatório)
  - Resposta: JSON com os detalhes do equipamento adicionado.
- Atualizar Equipamento de um Projeto
  - Endpoint: `/api/projects/{id}/equipments`
  - Método: `PUT`
  - Descrição: Atualiza um equipamento associado a um projeto específico.
  - Parâmetros:
    - `type` (enum, opcional)
    - `quantity` (integer, opcional)
  - Resposta: JSON com os detalhes do equipamento atualizado.
- Remover Equipamento de um Projeto
  - Endpoint: `/api/projects/{id}/equipments`
  - Método: `DELETE`
  - Descrição: Remove um equipamento de um projeto específico.
  - Resposta: Status de sucesso ou erro.
- Listar Todos os Equipamentos
  - Endpoint: `/api/projects/equipments`
  - Método: `GET`
  - Descrição: Retorna uma lista de todos os equipamentos disponíveis no sistema.
  - Resposta: JSON com a lista de equipamentos.
- Listar Todos os Tipos de Instalação
  - Endpoint: `/api/projects/installation-types`
  - Método: `GET`
  - Descrição: Retorna uma lista de todos os tipos de instalação disponíveis no sistema.
  - Resposta: JSON com a lista de tipos de instalação.
 
## 4. Instruções de Instalação

### Pré-requisitos

- PHP: Versão 8.0 ou superior.
- Composer: Gerenciador de dependências PHP.
- Docker: Para execução em ambiente Dockerizado.
- Docker Compose: Para gerenciar contêineres Docker.

# Passos de Instalação

1. Clone o repositório:
   ```
   git clone https://github.com/rebekaodilon/solar-projects.git
   cd solar-projects
   ```
2. Instale as dependências:
   ```
   composer install
   ```
3. Copie o arquivo `.env.example` para `.env`:
   ```
   cp .env.example .env
   ```
4. Configure o arquivo `.env`:
   - Configure as variáveis de ambiente, como DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD, etc.
5. Gere a chave da aplicação:
   ```
   php artisan key:generate
   ```
6. Configure o ambiente Docker:
   - Certifique-se de que o Docker e o Docker Compose estejam instalados e configurados.
   - Execute o comando para subir os contêineres:
     ```
     docker-compose up -d
     ```
7. Execute as migrações e seeders:
   ```
   php artisan migrate --seed
   ```
8. Inicie o servidor:
   ```
   php artisan serve
   ```
O sistema estará disponível em http://localhost:8080.

## 5. Instruções de Uso
# Acesso à API

- Autenticação: Para acessar os endpoints protegidos, você deve primeiro se autenticar usando o endpoint de login para obter um token JWT.
- Cabeçalho de Autorização: Em cada requisição subsequente, inclua o token no cabeçalho de autorização:
  ```
  Authorization: Bearer {token}
  ```
# Testes
O sistema inclui testes unitários que podem ser executados com o comando:
```
php artisan test
```
# Documentação da API com Swagger:
O sistema possui uma documentação interativa da API, acessível por meio do Swagger. Para visualizar e testar os endpoints, acesse:
- Link: http://localhost:8080/api/documentation#/
