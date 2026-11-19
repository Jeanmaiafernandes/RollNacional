# RollNacional

Mesa virtual para RPG, pensada para os sistemas nacionais e para os que os outros sites esquecem. Começa por **Tormenta20** e **D&D 5e**: fichas que calculam sozinhas, compêndio de regras e, na próxima etapa, a mesa de jogo em tempo real.

## Estado atual — Etapa 1

| Área | Situação |
| --- | --- |
| Cadastro, login e sair | Pronto (sem recuperação de senha e sem verificação de e-mail, por decisão do projeto) |
| Página inicial pública | Pronta, com banner animado em SVG |
| Início (painel) | Pronto, com estados vazios enquanto não há fichas |
| Perfil público | Pronto (`/usuarios/{nome_usuario}`) |
| Editar perfil, dados da conta e senha | Prontos |
| Sistemas e compêndio | Em construção (tabela `sistemas` em andamento) |
| Personagens e fichas | Em construção |

## Tecnologias

- **Laravel 13** com **PHP 8.4**
- **Blade** para as views, sem starter kit
- **Tailwind CSS v4** pelo Standalone CLI (sem Node e sem Vite)
- **Alpine.js** servido localmente em `public/js/alpine.min.js`
- Fontes **Oswald** (rótulos, menus, botões) e **Zilla Slab** (títulos e textos), pelo Google Fonts

## Requisitos

- PHP 8.4 com as extensões padrão do Laravel
- Composer
- Um banco de dados suportado pelo Laravel (MySQL, MariaDB, PostgreSQL ou SQLite)

## Instalação

```bash
git clone <url-do-repositorio> rollnacional
cd rollnacional

composer install
cp .env.example .env
php artisan key:generate
```

No `.env`, configure o banco e deixe idioma e fuso no Brasil:

```dotenv
APP_NAME=RollNacional
APP_LOCALE=pt_BR
APP_TIMEZONE=America/Sao_Paulo
```

Depois:

```bash
php artisan migrate
php artisan storage:link
```

### CSS (Tailwind Standalone)

Baixe o binário uma vez (Linux x64; para outros sistemas, troque o nome do arquivo pelo da sua plataforma na página de releases do Tailwind):

```bash
mkdir -p bin
curl -sSL -o bin/tailwindcss https://github.com/tailwindlabs/tailwindcss/releases/latest/download/tailwindcss-linux-x64
chmod +x bin/tailwindcss
```

Compile:

```bash
./bin/tailwindcss -i resources/css/app.css -o public/css/app.css --minify
```

Durante o desenvolvimento, deixe recompilando a cada alteração:

```bash
./bin/tailwindcss -i resources/css/app.css -o public/css/app.css --watch
```

Toda classe nova usada numa view só passa a existir depois de recompilar.

### Rodando

```bash
php artisan serve
```

## Comandos úteis

| Comando | Para quê |
| --- | --- |
| `php artisan optimize:clear` | Limpa cache de views, rotas e configuração |
| `php artisan view:clear` | Limpa só o cache das views |
| `php artisan route:list --except-vendor` | Lista as rotas do projeto |
| `php artisan migrate:fresh` | Recria o banco do zero (apaga os dados) |

## Estrutura

```
app/
├── Http/Controllers/
│   ├── Autenticacao/        CadastroController, LoginController, LogoutController
│   ├── Usuario/             UsuarioController (perfil público),
│   │                        EditarPerfilController, PerfilController (dados e senha)
│   └── PainelController.php
├── Http/Requests/
│   ├── Autenticacao/        CadastroRequest, LoginRequest
│   └── Usuario/             AtualizarPerfilPublicoRequest, AtualizarEmailRequest, AtualizarSenhaRequest
└── Models/Usuario.php

routes/
├── web.php                  página inicial pública, painel e carregamento de routes/web/*.php
├── autenticacao.php         cadastro, login e sair
└── web/                     um arquivo por área (conta.php, usuarios.php, ...)

resources/
├── css/app.css              tokens do tema, classes de componente e animações do banner
└── views/
    ├── layouts/             app (logado), publico (página inicial), visitante (entrar e criar conta)
    │   └── partials/        head, cabeçalhos, rodapé, avisos, marca, runas
    ├── components/          campo (formulário) e retrato (foto ou silhueta)
    ├── publico/             página inicial e o banner animado
    ├── autenticacao/        entrar e registrar
    ├── conta/               perfil, dados, senha e o menu lateral
    ├── usuarios/            perfil público
    └── inicio.blade.php     painel

public/img/
├── site/                    ilustrações do site (castelo, aventureiros, dragão)
└── sistemas/                capas e artes dos sistemas
```

## Rotas principais

| Método | Endereço | Nome | O que faz |
| --- | --- | --- | --- |
| GET | `/` | `pagina-inicial` | Página pública; quem está logado vai para o painel |
| GET/POST | `/registrar` | `registrar` | Cadastro |
| GET/POST | `/entrar` | `entrar` | Login |
| POST | `/sair` | `sair` | Logout |
| GET | `/inicio` | `inicio` | Painel do usuário |
| GET | `/usuarios/{nome_usuario}` | `usuarios.show` | Perfil público |
| GET/PUT | `/conta/perfil` | `conta.perfil` / `conta.perfil.atualizar` | Editar perfil público |
| GET/PUT | `/conta` | `conta.dados` / `conta.email` | Dados da conta (e-mail) |
| GET/PUT | `/conta/senha` | `conta.senha` / `conta.senha.atualizar` | Trocar senha |

Tudo fora de `/`, `/entrar` e `/registrar` exige login (`auth` e `auth.session`).

## Convenções

- **Código em português**: tabelas, colunas, rotas, classes e views.
- **Tabela `usuarios`**, model `App\Models\Usuario`:
  - a senha fica na coluna `senha` (o model define `$authPasswordName = 'senha'`);
  - as datas são `criado_em` e `atualizado_em` (constantes `CREATED_AT` e `UPDATED_AT`);
  - no `Auth::attempt`, a senha vai na chave `password`, porque é a chave que o Laravel usa para comparar com o hash, mesmo com a coluna chamada `senha`.
- **Confirmação de senha**: o campo se chama `senha_confirmation` (regra `confirmed`).
- **Views cruas**: páginas com `@extends` e `@section`. Componentes só para o que se repete em várias telas (`x-campo`, `x-retrato`).
- **Visual**: cores e fontes como tokens no `@theme` do `app.css`. Peças repetidas viram classes (`.btn`, `.btn-sec`, `.cartao`, `.bilhete`, `.etiqueta`, `.rotulo`...), em vez de listas longas de utilitários no Blade.
- **Links opcionais**: menus e botões que apontam para áreas ainda não criadas usam `Route::has()` e somem enquanto a rota não existe.
- **Uploads** (fotos de perfil) ficam em `storage/app/public/avatares` e são servidos pelo link criado no `storage:link`.

## Próximos passos

1. Tabela `sistemas` e as telas de sistemas e compêndio.
2. Personagens: lista, nova ficha e as fichas de Tormenta20 e D&D 5e.
3. Etapa 2: mesa virtual em tempo real (mapa, rolagens compartilhadas).

## Créditos e marcas

- Tormenta20 é marca da Jambô Editora. Dungeons & Dragons é marca da Wizards of the Coast. O RollNacional não tem vínculo oficial com as editoras.
- As capas e artes dos sistemas pertencem às respectivas editoras. Confirme a autorização de uso antes de publicar o site.
- As ilustrações em `public/img/site` foram geradas para este projeto.
