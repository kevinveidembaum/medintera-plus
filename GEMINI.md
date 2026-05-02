<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- inertiajs/inertia-laravel (INERTIA_LARAVEL) - v3
- laravel/fortify (FORTIFY) - v1
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/wayfinder (WAYFINDER) - v0
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- \@inertiajs/vue3 (INERTIA_VUE) - v3
- tailwindcss (TAILWINDCSS) - v4
- vue (VUE) - v3
- \@laravel/vite-plugin-wayfinder (WAYFINDER_VITE) - v0
- eslint (ESLINT) - v9
- prettier (PRETTIER) - v3

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== inertia-laravel/core rules ===

# Inertia

- Inertia creates fully client-side rendered SPAs without modern SPA complexity, leveraging existing server-side patterns.
- Components live in `resources/js/pages` (unless specified in `vite.config.js`). Use `Inertia::render()` for server-side routing instead of Blade views.
- ALWAYS use `search-docs` tool for version-specific Inertia documentation and updated code examples.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

# Inertia v3

- Use all Inertia features from v1, v2, and v3. Check the documentation before making changes to ensure the correct approach.
- New v3 features: standalone HTTP requests (`useHttp` hook), optimistic updates with automatic rollback, layout props (`useLayoutProps` hook), instant visits, simplified SSR via `@inertiajs/vite` plugin, custom exception handling for error pages.
- Carried over from v2: deferred props, infinite scroll, merging props, polling, prefetching, once props, flash data.
- When using deferred props, add an empty state with a pulsing or animated skeleton.
- Axios has been removed. Use the built-in XHR client with interceptors, or install Axios separately if needed.
- `Inertia::lazy()` / `LazyProp` has been removed. Use `Inertia::optional()` instead.
- Prop types (`Inertia::optional()`, `Inertia::defer()`, `Inertia::merge()`) work inside nested arrays with dot-notation paths.
- SSR works automatically in Vite dev mode with `@inertiajs/vite` - no separate Node.js server needed during development.
- Event renames: `invalid` is now `httpException`, `exception` is now `networkError`.
- `router.cancel()` replaced by `router.cancelAll()`.
- The `future` configuration namespace has been removed - all v2 future options are now always enabled.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== wayfinder/core rules ===

# Laravel Wayfinder

Use Wayfinder to generate TypeScript functions for Laravel routes. Import from `@/actions/` (controllers) or `@/routes/` (named routes).

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== inertia-vue/core rules ===

# Inertia + Vue

Vue components must have a single root element.

- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

</laravel-boost-guidelines>

## Contexto do Projeto: MedIntera+

1. Visão GeralO MedIntera+ é um sistema integrado de consulta multidisciplinar voltado para a gestão de informações sobre medicamentos, interações farmacológicas (fármaco-fármaco e fármaco-nutriente) e condutas clínicas. O objetivo principal é apoiar profissionais de saúde (médicos, nutricionistas e enfermeiros) na identificação de riscos e na tomada de decisão clínica.

2. Escopo TécnicoBanco de Dados: Utiliza PostgreSQL com modelagem normalizada em 3FN (Terceira Forma Normal). Arquitetura de Dados: Estrutura baseada em tabelas de referência (lookups) para garantir a integridade e evitar redundâncias. Entidade Central: A tabela medicamento atua como o núcleo, relacionando-se com princípios ativos, classificações, sintomas e alterações laboratoriais.

3. Principais Funcionalidades (Requisitos)O sistema deve permitir:Pesquisa Personalizada: Busca por nome comercial, princípio ativo ou classe farmacológica. Análise de Sintomas e Exames: Identificar medicamentos associados a queixas clínicas ou alterações em parâmetros laboratoriais (ex: glicemia, eletrólitos). Visualização de Interações: Exibir alertas sobre interações graves e orientações específicas para cada área profissional. Gestão de Dados: Cadastro, atualização e importação de bases de dados via planilhas (Excel/CSV).

## Requisitos Técnicos e Stack Tecnológica

O desenvolvimento do MedIntera+ deve seguir rigorosamente as definições abaixo para garantir consistência e performance:

5.1. Backend & Arquitetura

Modelo Arquitetural: Monólito com Inertia.js.

O roteamento e os controladores permanecem no Laravel.

O Inertia.js atua como a ponte, eliminando a necessidade de uma API separada e permitindo uma experiência de SPA (Single Page Application).

Banco de Dados: PostgreSQL.

A modelagem deve seguir a Terceira Forma Normal (3FN) documentada.

Uso obrigatório de Migrations e Eloquent ORM.

Estilização: Tailwind CSS (padrão recomendado para ecossistema Laravel).

Renderização: Client-side via Inertia.

5.3. Metodologia de Desenvolvimento: TDD (Test Driven Development)
O agente de IA deve operar sob o ciclo Red-Green-Refactor. Nenhuma funcionalidade deve ser implementada sem antes possuir um teste que valide sua falha e, posteriormente, seu sucesso.

Ferramenta de Teste: PHPUnit ou Pest (conforme preferência do desenvolvedor).

Tipos de Testes Requeridos:

Feature Tests: Testar o comportamento do usuário e as rotas da aplicação (ex: buscar um medicamento, importar uma planilha).

Unit Tests: Testar lógicas isoladas e regras de negócio (ex: cálculos de dosagem ou filtros de interação).

Mocking: Uso obrigatório de Mocks e Factories para isolar dependências externas e garantir que os testes sejam rápidos e independentes de dados reais ou estados de rede.

Cobertura: O objetivo é a cobertura total das lógicas críticas do sistema.

5.4. Fluxo de Trabalho do Agente
Análise do Requisito: Compreender a feature baseada na documentação e planilha.

Criação do Teste (Red): Escrever o código de teste que descreve a funcionalidade. O teste deve falhar inicialmente.

Implementação (Green): Escrever o código de produção mínimo necessário para fazer o teste passar.

Refatoração (Refactor): Otimizar o código mantendo o teste passando.

Sempre fazer o teste antes da implementação da funcionalidade.

## Requisitos Funcionais

RF01
Pesquisa por nome
comercial
Permitir ao usuário localizar informações a partir do
nome comercial do medicamento.

RF02 Pesquisa por princípio ativo
Permitir busca por fármaco para identificação de
medicamentos equivalentes ou relacionados.

RF03
Consulta por classificação
farmacológica
Exibir medicamentos filtrados por sua classe
terapêutica (ex.: mucolítico, diurético,
antiglaucoma).

RF04
Pesquisa por sinais e
sintomas
Listar medicamentos associados às queixas clínicas
relatadas pelos pacientes (sintomatologia).

RF05
Pesquisa por alterações
laboratoriais
Exibir possíveis alterações bioquímicas que podem
ocorrer em decorrência do uso dos medicamentos.

RF06 Visualização de interações
Exibir potenciais interações relevantes descritas na
base, incluindo interações com alimentos.

RF07
Exibição de ações
multiprofissionais
Mostrar orientações específicas para médicos,
nutricionistas e equipe de enfermagem.

RF08
Cadastro e atualização de
registros
Permitir inserir, editar e atualizar informações dos
medicamentos na base.

RF09
Filtrar medicamentos por
risco ou precauções
Permitir consulta a medicamentos que exigem
precauções específicas (ex.: insuficiência renal,
lactação).

RF10 Exportação de resultados
Permitir exportar consultas em formato PDF ou
Excel para apoio clínico.

## Requisitos Não funcionais

RNF01 Segurança da informação Garantir proteção dos dados, seguindo boas práticas de
segurança e sigilo clínico.

RNF02
Desempenho e rapidez
de consulta
As buscas devem retornar resultados em poucos
segundos, mesmo com grande volume de dados.

RNF03 Disponibilidade
O sistema deve permanecer acessível durante o horário
de funcionamento clínico, com mínima
indisponibilidade.

RNF04 Escalabilidade
A arquitetura deve permitir expansão para novos
medicamentos, novas categorias e novas instituições.

RNF05 Usabilidade
A interface deve ser intuitiva, permitindo que
profissionais de diferentes áreas utilizem o sistema sem
treinamento extenso.

RNF06
Padronização
terminológica
O banco deve seguir terminologias reconhecidas (ex.:
DCB, CID, classificações farmacológicas).

RNF07 Integridade dos dados
Informações cadastradas devem manter consistência e
evitar duplicidade.

RNF08 Portabilidade
O sistema deve funcionar em diferentes dispositivos
(desktop, tablet).

RNF09
Auditoria e
rastreabilidade
Qualquer alteração nos registros deve ser registrada com
data, horário e responsável.

RNF10
Conformidade ética e
legal
O desenvolvimento deve seguir normas éticas exigidas
para pesquisas com instituições de saúde e boas práticas
de software.

## Estrutura do Banco de Dados (Schema)

O modelo lógico apresentado organiza as informações do domínio farmacológico em
tabelas normalizadas de forma a facilitar consultas, manutenção e expansão. As entidades
principais são:
-medicamento: registro central que agrega informações sobre o produto comercial,
referenciando seus atributos semânticos (princípio ativo, classificação,
sintomatologia, alterações laboratoriais, interações e orientações
multiprofissionais).
-principio_ativo: catálogo de princípios ativos (nome do fármaco), permitindo
buscas por substância ativa e evitando redundância de texto.
-classificacao_medicamento: tabela de classes terapêuticas (ex.: mucolítico,
diurético) usada para filtragem por grupo farmacológico.
25
-sintomatologia: tabela com descrições de sinais e sintomas associados ao uso ou
indicação do medicamento.
-alteracao_laboratorial: tabela de parâmetros laboratoriais que podem ser alterados
pelo uso do medicamento (ex.: Na+, K+, glicemia).
-interacao: tabela descritiva das interações (breve descrição / categoria), utilizada
para relacionar medicamentos a interações documentadas.
-acao_medicina, acao_nutricao, acao_enfermagem: tabelas com orientações ou
condutas sugeridas aos diferentes profissionais da equipe multiprofissional.

## Relações e cardinalidades

No modelo lógico, a tabela medicamento referencia, por meio de chaves
estrangeiras, cada uma das tabelas de catálogo, como princípio ativo, classificação,
sintomatologia, alterações laboratoriais, interações e ações multiprofissionais. As
26
cardinalidades indicam uma relação do tipo (0,n) no lado de medicamento para (1,1) no
lado das tabelas de referência, evidenciando que um medicamento pode estar associado a
um registro específico de cada catálogo, enquanto cada item de catálogo pode ser utilizado
por vários medicamentos. Essa estrutura facilita a integridade dos dados e permite ampliar
o uso de categorias padronizadas. Além disso, o modelo foi estruturado para privilegiar
consultas diretas e joins simples, permitindo atender aos requisitos de busca solicitados
pela gestora, como pesquisa por nome comercial, princípio ativo, parâmetros laboratoriais
e sintomas relatados pelos pacientes.

## Script SQL (PostgreSQL) para criação do banco de dados do Sistema

MedIntera+

```pgsql

-- SCRIPT DE CRIAÇÃO DO BANCO DE DADOS (PostgreSQL)
-- Esquema: medintera
-- Cria schema opcional
CREATE SCHEMA IF NOT EXISTS medintera;
SET search_path = medintera, public;
-- Tabelas de referência / lookup
CREATE TABLE principio_ativo (
id_principio_ativo INTEGER PRIMARY KEY,
nome_principio_ativo VARCHAR(255) NOT NULL
);
CREATE TABLE classificacao_medicamento (
id_classificacao INTEGER PRIMARY KEY,
classificacao VARCHAR(200) NOT NULL
);
CREATE TABLE sintomatologia (
id_sintomatologia INTEGER PRIMARY KEY,
descricao VARCHAR(500) NOT NULL
);

CREATE TABLE alteracao_laboratorial (
id_alt_lab INTEGER PRIMARY KEY,
descricao VARCHAR(300) NOT NULL
);
CREATE TABLE interacao (
id_interacao INTEGER PRIMARY KEY,
descricao VARCHAR(1000) NOT NULL
);
CREATE TABLE acao_medicina (
id_acao_med INTEGER PRIMARY KEY,
descricao VARCHAR(1000) NOT NULL
);
CREATE TABLE acao_nutricao (
id_acao_nut INTEGER PRIMARY KEY,
descricao VARCHAR(1000) NOT NULL
);
CREATE TABLE acao_enfermagem (
id_acao_enf INTEGER PRIMARY KEY,
descricao VARCHAR(1000) NOT NULL
);

-- Tabela central: medicamento
CREATE TABLE medicamento (
id_medicamento INTEGER PRIMARY KEY,
nome_comercial VARCHAR(255) NOT NULL,

-- Chaves estrangeiras para as tabelas lookup (com ON DELETE SET NULL)
id_principio_ativo INTEGER REFERENCES principio_ativo(id_principio_ativo) ON DELETE SET
NULL,
id_classificacao INTEGER REFERENCES classificacao_medicamento(id_classificacao) ON DELETE
SET NULL,
id_sintomatologia INTEGER REFERENCES sintomatologia(id_sintomatologia) ON DELETE SET
NULL,
id_alt_lab INTEGER REFERENCES alteracao_laboratorial(id_alt_lab) ON DELETE SET NULL,
id_interacao INTEGER REFERENCES interacao(id_interacao) ON DELETE SET NULL,
id_acao_med INTEGER REFERENCES acao_medicina(id_acao_med) ON DELETE SET NULL,
id_acao_nut INTEGER REFERENCES acao_nutricao(id_acao_nut) ON DELETE SET NULL,
id_acao_enf INTEGER REFERENCES acao_enfermagem(id_acao_enf) ON DELETE SET NULL,

observacoes TEXT
);

-- Tabela associativa para interações (Muitos-para-Muitos)
CREATE TABLE medicamento_interacao (
id_med_interacao INTEGER PRIMARY KEY,
-- ON DELETE CASCADE: se o medicamento de origem/alvo for deletado, a interação é deletada
medicamento_origem INTEGER NOT NULL REFERENCES medicamento(id_medicamento) ON
DELETE CASCADE,
medicamento_alvo INTEGER NOT NULL REFERENCES medicamento(id_medicamento) ON
DELETE CASCADE,
-- ON DELETE SET NULL: se a descrição da interacao for deletada, a FK fica NULL
id_interacao INTEGER REFERENCES interacao(id_interacao) ON DELETE SET NULL,
severidade VARCHAR(50),
descricao TEXT
);
-- Fim do script
```
