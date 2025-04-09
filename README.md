# Desafio Full Stack – Carteira Digital (Laravel + Docker)

Este projeto consiste em uma aplicação web construída com Laravel e Docker simulando uma carteira digital com funcionalidades de depósito, transferência de valores entre usuários, histórico de transações e reversão de transferências.

## Funcionalidades

- Cadastro e login de usuários
- Criação automática de carteira ao registrar
- Depósito de valores
- Transferência de valores entre carteiras (via Wallet ID)
- Histórico de transações (com reversão)
- Exibição de saldo e Wallet ID no topo da interface
- Observabilidade com logs estruturados
- Testes automatizados com PHPUnit



## Tecnologias e Padrões

- **PHP 8+** com **Laravel**
- **Docker + Docker Compose**
- **PostgreSQL** como banco de dados
- **Bootstrap 5** com Blade (Laravel Breeze adaptado)
- **Design Patterns**: Service Layer
- **Princípios SOLID**
- **Testes com PHPUnit**
- **Log com Laravel Log Facade**



## Como rodar com Docker

Clone o projeto e execute:

```bash
git clone https://github.com/luizreimann/desafio-adriano-cobuccio.git
cd desafio-adriano-cobuccio
```

Crie o `.env`:

```bash
cp .env.example .env
```

Suba os containers:

```bash
docker-compose up -d
```

Instale dependências e gere a key:

```bash
docker exec -it app bash

composer install
php artisan key:generate
php artisan migrate:fresh --seed
npm install && npm run build
```



## 👤 Usuários pré-cadastrados (Seeder)

| Nome       | E-mail                   | Senha     | Wallet ID       |
|------------|--------------------------|-----------|-----------------|
| Alberto    | albertogomes@gmail.com   | password  | exibido no topo |
| Rubens     | rubensnogueira@gmail.com | password  | exibido no topo |



## Regras de Negócio

- Transferência requer Wallet ID do destinatário
- Usuário não pode transferir valores maiores do que o saldo
- Transações podem ser revertidas (exceto depósitos já revertidos)
- Todas as movimentações são logadas



## Rodando os Testes

```bash
php artisan test
```

Testes de:
- Depósito
- Transferência com e sem saldo
- Autenticação e registro
- Atualização e exclusão de perfil



## Observabilidade

- Logs das operações financeiras em (`storage/logs/laravel.log`)



## Melhorias Futuras

- API RESTful
- Filtros no histórico de transações
- Confirmação de email no registro
- Dashboard com gráficos de movimentações