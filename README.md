# Form Empresas

Sistema de cadastro de empresas utilizando Laravel, Inertia.js e Vue 3.

## Tecnologias Utilizadas

- **Backend:** [Laravel](https://laravel.com/) 12.x
- **Frontend:** [Vue 3](https://vuejs.org/) + [Inertia.js](https://inertiajs.com/)
- **Estilos:** [Tailwind CSS](https://tailwindcss.com/)
- **Validação e Testes:** [Pest](https://pestphp.com/), [PHPUnit](https://phpunit.de/)
- **Automação de Git Hooks:** [Husky](https://typicode.github.io/husky/) para rodar testes automatizados antes de commits e push
- **Qualidade de Código:** [Laravel Pint](https://laravel.com/docs/12.x/pint), [Larastan](https://github.com/larastan/larastan)
- **Outros:** [Ziggy](https://github.com/tighten/ziggy) para rotas JS, [Vite](https://vitejs.dev/) para build frontend

## ⚙️ Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL ou outro banco de dados compatível
- [Herd Laravel](https://herd.laravel.com/) (opcional, para ambiente local simplificado)

> Com Herd, você pode acessar o projeto via `http://form-empresas.test`.

## Instalação

1. **Clone o repositório:**
   ```sh
   cd Herd
   git clone https://github.com/guilhermehiginoo/form-empresas
   cd form-empresas
   ```

2. **Instale as dependências do PHP e Node.js:**
   ```sh
   composer install
   npm install
   ```

3. **Configure o ambiente:**
   ```sh
   cp .env.example .env
   ```

4. **Rode as migrations:**
   ```sh
   php artisan migrate:fresh --seed
   ```

5. **Inicie os servidores de desenvolvimento:**
   - Frontend:
     ```sh
     npm run dev
     ```

## Scripts Úteis

- **Testes:**
  ```sh
  php artisan test
  ```

- **Análise estática com Larastan:**
  ```sh
  ./vendor/bin/phpstan analyse
  ```

- **Padronização de código com Laravel Pint:**
  ```sh
  ./vendor/bin/pint
  ```

- **Build de produção:**
  ```sh
  npm run build
  ```

## Estrutura do Projeto

- `app/` - Código backend Laravel (controllers, models, etc)
- `resources/js/` - Código frontend Vue 3 + Inertia.js
- `routes/` - Rotas Laravel
- `database/` - Migrations, seeders e factories
- `tests/` - Testes automatizados (Pest/PHPUnit)

## Qualidade de Código

- **Laravel Pint:** Utilizado para padronização automática do código PHP.
- **Larastan:** Utilizado para análise estática e detecção de possíveis bugs no código PHP.
- **Husky:** Execução de testes automatizados via Git hooks (pré-commit/push). 

---

## Autor

> Desenvolvido por [Guilherme Higino](https://github.com/guilhermehiginoo) 
> Projeto desenvolvido com foco em boas práticas, tipagem, testes e experiência do usuário.
