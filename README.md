# Onfly Booking System

Microsserviço Laravel para gerenciamento de pedidos de viagem corporativa.  
Este serviço expõe uma API REST protegida com autenticação JWT.

---

##  Requisitos

- PHP 8.2 ou superior → `php -v`
- Composer → `composer --version`
- Node.js 22 ou superior → `node -v`
- Docker + Docker Compose (para rodar localmente)

---

##  Como rodar o projeto com Docker

1. Clone o repositório:

```bash
git clone https://github.com/Armandomateus41/onfly-booking-system.git
cd onfly-booking-system
```

2. Suba os containers:

```bash
docker-compose up -d --build
```

3. Gere a chave JWT:

```bash
docker exec -it laravel_app php artisan jwt:secret
```

4. Rode as migrations e seeders:

```bash
docker exec -it laravel_app php artisan migrate:fresh --seed
```

5. Acesse a aplicação (modo API):

```
http://localhost:8000
```

---

##  Autenticação JWT

### Endpoints públicos:
- `POST /api/register` – Cria um novo usuário
- `POST /api/login` – Autentica e retorna um token

### Endpoints protegidos (JWT):
Utilize o token como Bearer Token no header `Authorization`.

- `GET /api/travel-requests` – Listar pedidos do usuário autenticado
- `POST /api/travel-requests` – Criar novo pedido
- `GET /api/travel-requests/{id}` – Detalhes de um pedido
- `PATCH /api/travel-requests/{id}/status` – Atualizar status (apenas outro usuário pode aprovar/cancelar)
- `DELETE /api/travel-requests/{id}` – Cancelar pedido aprovado

---

##  Testes

Execute os testes com:

```bash
docker exec -it laravel_app php artisan test
```

---

##  Dados de Teste

Os seeders criam:

- Usuário: `test@example.com`
- Senha: `123456`
- 10 pedidos de viagem relacionados a esse usuário

---

##  Estrutura do projeto

- `app/Http/Controllers/TravelRequestController.php` – Lógica da API
- `routes/api.php` – Rotas protegidas com JWT
- `app/Models/TravelRequest.php` – Model principal
- `database/seeders/` – Dados de teste com UserSeeder e TravelRequestSeeder
- `docker-compose.yml` – Ambiente completo com Laravel + MySQL

---

##  Autor

Este projeto foi desenvolvido por [Armando Mateus](https://github.com/Armandomateus41)  
Repositório: [onfly-booking-system](https://github.com/Armandomateus41/onfly-booking-system)
