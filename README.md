# Ponto Eletrônico

Aplicação simples de **registro de ponto eletrônico** desenvolvida em **Laravel 11**.  
O objetivo é permitir que funcionários registrem suas batidas de ponto e que administradores gerenciem usuários e visualizem relatórios — incluindo um **relatório especial gerado com SQL puro**.

> **Recursos implementados:** Migrations, Eloquent (exceto no relatório), validações (incluindo CPF), consulta de CEP via ViaCEP, relações adequadas, organização de código e fluxo de versionamento sugerido.

---

## Sumário
- [Visão Geral](#visão-geral)
- [Stack e Requisitos](#stack-e-requisitos)
- [Passo a Passo — Setup do Projeto](#passo-a-passo--setup-do-projeto)
- [Variáveis de Ambiente (.env)](#variáveis-de-ambiente-env)
- [Banco de Dados & Modelagem](#banco-de-dados--modelagem)
- [Autenticação e Perfis](#autenticação-e-perfis)
- [Funcionalidades](#funcionalidades)
- [Rotas Principais](#rotas-principais)
- [Relatório (SQL Puro)](#relatório-sql-puro)
- [Validações Importantes](#validações-importantes)
- [Estrutura de Pastas](#estrutura-de-pastas)
- [Fluxo de Branches & Commits](#fluxo-de-branches--commits)
- [Boas Práticas & Segurança](#boas-práticas--segurança)
- [Scripts Úteis](#scripts-úteis)
- [Licença](#licença)

---

## Visão Geral

**Perfil Funcionário**
- Login e autenticação
- Registro de ponto (um clique)
- Alteração de senha

**Perfil Administrador**
- CRUD completo de funcionários
- Visualização da lista de pontos de qualquer funcionário
- Filtro por período (entre duas datas)
- Cada funcionário vinculado ao administrador que o cadastrou

**Relatório Especial**
- Construído em **SQL puro**
- Campos: ID do registro, nome do funcionário, cargo, idade, nome do gestor, data e hora (com segundos)

---

## Stack e Requisitos

- **PHP 8.2+**
- **Composer 2+**
- **MySQL 8+** (Engine **InnoDB**)
- **Node.js 18+ / NPM** (para assets do Breeze/Blade, se aplicável)
- **Laravel 11**

> Opcional: Docker ou WSL2 podem ser usados de acordo com a preferência do desenvolvedor.

---

## Passo a Passo — Setup do Projeto

> Supondo que o repositório já esteja clonado ou baixado.  
> Caso esteja iniciando do zero, veja o fluxo de branches ao final.

1. **Instalar dependências PHP**
```bash
composer install
```

2. **Copiar `.env` e gerar chave da aplicação**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configurar Banco de Dados**  
Edite o `.env` com suas credenciais MySQL (ver seção [Variáveis de Ambiente](#variáveis-de-ambiente-env)).

4. **Executar migrations**
```bash
php artisan migrate
```

5. **(Opcional) Popular administrador inicial**
```bash
php artisan db:seed --class=AdminUserSeeder
```
**Credenciais padrão (apenas para desenvolvimento):**
- E-mail: `admin@example.com`
- Senha: `password123`
- CPF: `00000000000`

> Recomenda-se alterar a senha após o primeiro login.

6. **Instalar dependências do front-end (se necessário)**
```bash
npm install
npm run dev
```
> Caso altere CSS ou JS, execute `npm run dev` ou `npm run build`.

7. **Subir o servidor de desenvolvimento**
```bash
php artisan serve
```
Acesse: **http://127.0.0.1:8000**

---

## Banco de Dados & Modelagem

**Tabelas principais**

- **`users`**
  - Campos adicionais: `cpf` (único), `cargo`, `birth_date`, `cep`, `street`, `number`, `complement`, `neighborhood`, `city`, `state`, `manager_id` (FK para `users.id`), `role` (`admin` | `employee`)
  - Relacionamentos:
    - `manager()` → `belongsTo(User, manager_id)`
    - `subordinates()` → `hasMany(User, manager_id)`
    - `punches()` → `hasMany(Punch)`

- **`punches`**
  - Campos: `id`, `user_id` (FK), `created_at`, `updated_at`

**Observações**
- Engine **InnoDB**
- Índice único para `cpf`
- `manager_id` com FK autorreferencial

---

## Autenticação e Perfis

- Campo `role` em `users` define o perfil (`admin` ou `employee`).
- Middleware `admin` protege rotas administrativas.

---

## Funcionalidades

### Funcionário
- Registro de ponto: cria entrada em `punches` com timestamp (`created_at`)
- Alteração de senha: formulário com validação da senha atual

### Administrador
- CRUD de funcionários
  - Validação de CPF (formato e unicidade), e-mail único, etc.
  - Associação automática de `manager_id` ao admin logado
- Visualização de pontos registrados, com filtro por período

---

## Relatório (SQL Puro)

Gerado via `DB::select` utilizando SQL puro, com junção `users` ↔ `users` (gestor) e cálculo de idade.

---

## Validações Importantes

- **CPF**
  - Validação de formato e unicidade
  - Rejeita CPFs inválidos ou duplicados
- **CEP / Endereço**
  - Consulta automática via **ViaCEP**
  - Preenchimento automático de rua, bairro, cidade e UF
- **Outros campos**
  - E-mail único
  - Senha com confirmação e requisitos mínimos
  - Limites de tamanho e tipos corretos

---

## Estrutura de Pastas

```
app/
  Http/
    Controllers/
    Middleware/
  Models/

database/
  migrations/
  seeders/

resources/
  views/
    layouts/
    employees/
    profile/
    punches/
    reports/

routes/
  web.php
  auth.php
```

---

## Fluxo de Branches & Commits

```
git checkout -b develop           # criar branch develop a partir da main
git checkout -b feature/xxx       # criar branch de feature
# commits pequenos e frequentes
git checkout develop
git merge --no-ff feature/xxx
git checkout main
git merge --no-ff develop         # release
```

---

## Boas Práticas & Segurança

- **Nunca** versionar `.env` real (apenas `.env.example`)
- Manter índices e FKs nas migrations
- Validação de dados em Form Requests ou no controller
- Utilizar políticas e middlewares para controle de acesso
- Atualizar dependências regularmente
- Configurar logs sem dados sensíveis
- Alterar senha do admin seed em produção

---

## Scripts Úteis

```bash
# Rodar servidor local
php artisan serve

# Executar migrations
php artisan migrate
php artisan migrate:rollback

# Popular administrador inicial
php artisan db:seed --class=AdminUserSeeder

# Limpar caches e configs
php artisan optimize:clear
```

---

## Licença

Projeto livre para estudo e aprendizado.
