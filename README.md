# MedIntera+

O **MedIntera+** é um sistema integrado de consulta multidisciplinar voltado para a gestão de informações sobre medicamentos, interações farmacológicas (fármaco-fármaco e fármaco-nutriente) e condutas clínicas.

## 🎯 Objetivo

O objetivo principal do sistema é apoiar profissionais de saúde (médicos, nutricionistas e enfermeiros) na identificação de riscos e na tomada de decisão clínica, consolidando dados complexos de interações e efeitos colaterais em uma interface intuitiva e rápida.

---

## ✨ Funcionalidades

O MedIntera+ atende aos seguintes requisitos funcionais (RF):

- **RF01/02/03:** Pesquisa avançada por nome comercial, princípio ativo ou classificação farmacológica.
- **RF04/05:** Busca por sinais, sintomas e alterações laboratoriais associadas ao uso de medicamentos.
- **RF06:** Visualização detalhada de interações fármaco-fármaco e fármaco-alimento com níveis de severidade.
- **RF07:** Exibição de ações e orientações específicas para cada área (Medicina, Nutrição e Enfermagem).
- **RF08:** Gestão administrativa para cadastro e atualização de registros.
- **RF09:** Filtros por grupos de risco ou precauções específicas (ex: lactação, insuficiência renal).
- **RF10:** Exportação de relatórios e consultas em PDF ou Excel.

---

## 🛠️ Tecnologias e Stack

O projeto utiliza o ecossistema moderno do Laravel com uma arquitetura SPA (Single Page Application):

- **Backend:** [Laravel 13](https://laravel.com) (PHP 8.5)
- **Frontend:** [Vue 3](https://vuejs.org) com [Inertia.js v3](https://inertiajs.com)
- **Estilização:** [Tailwind CSS v4](https://tailwindcss.com)
- **Banco de Dados:** [PostgreSQL](https://www.postgresql.org) (Modelagem 3FN)
- **Roteamento Frontend:** [Laravel Wayfinder](https://github.com/laravel/wayfinder) (Tipagem TypeScript para rotas)
- **Testes:** [Pest PHP v4](https://pestphp.com)

---

## 🏗️ Arquitetura

O sistema segue o padrão de **Monólito com Inertia.js**, utilizando uma camada de serviço (**Service Layer**) para isolar a lógica de negócio dos controladores.

### Camadas Principais:
1.  **Controllers:** Atuam como orquestradores, validando requisições e chamando os serviços.
2.  **Services:** Contêm a lógica complexa (cruzamento de dados, filtros de busca, processamento de arquivos).
3.  **Models (Eloquent):** Definem a estrutura de dados e relacionamentos normalizados.
4.  **Inertia Pages:** Componentes Vue que recebem dados diretamente do backend sem a necessidade de uma API REST tradicional.

---

## 📁 Estrutura de Pastas

```text
├── app/
│   ├── Http/Controllers/    # Controladores (Medicamento, Interação, etc.)
│   ├── Models/              # Modelos Eloquent (Medicamento, PrincipioAtivo, etc.)
│   ├── Services/            # Lógica de Negócio (Importação, Exportação, Busca)
│   └── Actions/Fortify/     # Lógica de Autenticação (Laravel Fortify)
├── config/                  # Configurações do framework
├── database/
│   ├── migrations/          # Definição do schema PostgreSQL
│   ├── seeders/             # Dados iniciais e importação da base real
│   └── factories/           # Geradores de dados para testes
├── resources/
│   ├── js/
│   │   ├── pages/           # Páginas Vue.js (Frontend)
│   │   ├── components/      # Componentes UI reutilizáveis
│   │   └── actions/         # Funções geradas pelo Wayfinder
│   └── views/               # Template base (Blade) e templates de exportação
├── routes/                  # Definições de rotas (Web, Console, Settings)
└── tests/                   # Testes automatizados (Feature e Unit)
```

---

## 📂 Importação e Exportação

O MedIntera+ possui um motor robusto para manipulação de grandes volumes de dados farmacológicos:

### Importação (`MedicamentoImportService`)
- Suporta arquivos **Excel (.xlsx)** e **CSV**.
- Realiza o mapeamento automático para as tabelas de referência (`principio_ativo`, `classificacao`, etc.).
- Garante a integridade referencial e evita duplicidade de registros.
- Localização dos arquivos base: `database/seeders/data/`.

### Exportação (`MedicamentoExportService`)
- **PDF:** Gera relatórios clínicos formatados para impressão.
- **Excel:** Exporta resultados de buscas e tabelas completas para análise externa.

---

## 🚀 Como Executar

### Pré-requisitos
- PHP 8.5+
- Composer
- Node.js & NPM
- PostgreSQL

### Instalação
1.  Clone o repositório:
    ```bash
    git clone https://github.com/seu-usuario/medintera-plus.git
    ```
2.  Instale as dependências:
    ```bash
    composer install
    npm install
    ```
3.  Configure o ambiente:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  Execute as migrações e seeders:
    ```bash
    php artisan migrate --seed
    ```
5.  Inicie o servidor de desenvolvimento:
    ```bash
    composer run dev
    ```

---

## 🧪 Testes

O projeto segue a metodologia **TDD (Test Driven Development)** com 100% de cobertura nas lógicas críticas.

Para rodar os testes:
```bash
php artisan test --compact
```
Os testes estão divididos em:
- **Feature Tests:** Validam fluxos de usuário (Busca, Login, Importação).
- **Unit Tests:** Validam regras de negócio isoladas nos Services.
