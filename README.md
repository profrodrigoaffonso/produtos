# Loja Virtual

Um aplicativo web de uma loja virtual.

## Funcionalidades

- Cadastrar categorias de produtos
- Cadastrar, importar e exportar em Excel produtos
- Cadastrar clientes
- Cadastrar formas de pagamentos
- Cadastrar administardores do sistema
- Área de compra do cliente

## Tecnologias utilizadas

- PHP 8.2
- Laravel 12
- MySQL
- HTML / CSS
- JavaScript
- Bootsrapp
- PHPOffice/PhpSpreadsheet

## Estrutura do projeto

```text

app/
├── Http/
│ └── Controllers/
│   ├── AdminController.php
|   ├── CategoriaController.php
|   ├── ClienteController.php
|   ├── FormaPagamentosController.php
|   ├── LoginController.php
|   ├── LojaController.php
|   └── ProdutoController.php
├── Models/
│ ├── Admin.php
│ ├── Carrinho.php
│ ├── Categoria.php
│ ├── Cliente.php
│ ├── Compra.php
│ ├── CompraProduto.php
│ ├── FormaPagamento.php
│ ├── Produto.php
│ └── User.php
routes/
├── api.php
└── web.php
