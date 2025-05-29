
# Cantina App Backend

![Laravel Logo](https://laravel.com/img/logomark.min.svg)

## Descrição

O **Cantina App Backend** é a API desenvolvida com o framework **Laravel** para gerenciar as operações de uma cantina escolar. Ele oferece funcionalidades como:

- Cadastro e autenticação de usuários (alunos, responsáveis e funcionários)
- Gerenciamento de produtos alimentícios
- Registro de pedidos e controle de estoque
- Relatórios e estatísticas de vendas

---

## Tecnologias Utilizadas

- **Backend**: PHP 8.1+ com o framework Laravel
- **Banco de Dados**: MySQL ou SQLite
- **Autenticação**: Laravel Sanctum ou Passport
- **Testes**: PHPUnit
- **Gerenciamento de Dependências**: Composer

---

## Estrutura do Projeto

```
├── app/            # Lógica da aplicação
├── bootstrap/      # Arquivos de inicialização
├── config/         # Arquivos de configuração
├── database/       # Migrations e seeds
├── public/         # Arquivos públicos (index.php, assets)
├── resources/      # Views e arquivos de tradução
├── routes/         # Definição das rotas da API
├── storage/        # Arquivos gerados (logs, uploads)
├── tests/          # Testes automatizados
├── .env.example    # Arquivo de exemplo de variáveis de ambiente
├── artisan         # CLI do Laravel
├── composer.json   # Dependências do PHP
└── phpunit.xml     # Configuração do PHPUnit
```

---

## Instalação

### 1. Clonar o repositório

```bash
git clone https://github.com/leonardo99/cantina-app-backend.git
cd cantina-app-backend
```

### 2. Instalar as dependências

```bash
composer install
```

### 3. Configurar as variáveis de ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` com as configurações do seu ambiente, como banco de dados e chave de aplicação.

### 4. Gerar a chave de aplicação

```bash
php artisan key:generate
```

### 5. Rodar as migrations

```bash
php artisan migrate
```

### 6. (Opcional) Rodar os seeders

```bash
php artisan db:seed
```

---

## Uso

### Servidor de Desenvolvimento

Para iniciar o servidor de desenvolvimento:

```bash
php artisan serve
```

A API estará disponível em `http://localhost:8000`.