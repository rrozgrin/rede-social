### Nome do Projeto: Rede Social

Rede Social é desenvolvida utilizando PHP com o framework Laravel, JavaScript com Vue.js 3, Tailwind CSS e MySQL. Esta plataforma oferece uma experiência interativa e dinâmica para conectar pessoas, compartilhar conteúdo e interagir em uma comunidade online.

---

### Funcionalidades Principais:

- **Registro e Autenticação de Usuários**: Permitindo que os usuários criem contas e façam login de forma segura.
  
- **Perfil de Usuário Personalizável**: Os usuários podem personalizar seus perfis, adicionando informações pessoais, fotos e outras configurações.
  
- **Feed de Notícias**: Um feed dinâmico que exibe postagens de amigos e seguidores, permitindo que os usuários interajam por meio de curtidas, comentários e compartilhamentos.
  
- **Sistema de Amigos e Seguidores**: Os usuários podem se conectar uns aos outros, adicionando na rede de conexão perfis para acompanhar suas atualizações.
    
- **Grupos e Comunidades**: Os usuários podem criar e participar de grupos e comunidades com interesses em comum.
  
---

### Requisitos de Instalação:

- PHP >= 7.4
- Composer
- Node.js e npm
- MySQL
- Git

---

### Como Instalar e Executar:

1. Clone este repositório: `git clone https://github.com/rrozgrin/rede-social.git`
2. Navegue até o diretório do projeto: `cd rede-social`
3. Instale as dependências do PHP: `composer install`
4. Copie o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente, como as credenciais do banco de dados.
5. Gere uma chave de aplicativo Laravel: `php artisan key:generate`
6. Execute as migrações do banco de dados: `php artisan migrate`
7. Instale as dependências do Node.js: `npm install`
8. Compile os ativos JavaScript e CSS: `npm run dev`
9. Inicie o servidor de desenvolvimento: `php artisan serve`

Acesse o aplicativo em seu navegador em `http://localhost:8000`.

---