<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;


Route::get('/', function () {
    return redirect(route('loja.index'));
});


Route::get('/login', function () {
    return view('login.index');
});



Route::post('/login', [LoginController::class, 'authenticate'])->name('login.login');

Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');



Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/verificacao', [LoginController::class, 'verificacao'])->name('admin.login.verificacao');

    Route::prefix('categorias')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('admin.categoria.index');
        Route::get('/novo', [CategoriaController::class, 'create'])->name('admin.categoria.create');
        Route::get('/{uuid}/editar', [CategoriaController::class, 'edit'])->name('admin.categoria.edit');
        Route::post('/salvar', [CategoriaController::class, 'store'])->name('admin.categoria.store');
        Route::put('/atualizar', [CategoriaController::class, 'update'])->name('admin.categoria.update');

    });
    Route::prefix('produtos')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('admin.produto.index');
        Route::get('/exportar', [ProdutoController::class, 'exportar'])->name('admin.produto.exportar');
        Route::get('/importar', [ProdutoController::class, 'importar'])->name('admin.produto.importar');
        Route::post('/upload', [ProdutoController::class, 'upload'])->name('admin.produto.upload');
        Route::get('/novo', [ProdutoController::class, 'create'])->name('admin.produto.create');
        Route::get('/{id}/editar', [ProdutoController::class, 'edit'])->name('admin.produto.edit');
        Route::post('/salvar', [ProdutoController::class, 'store'])->name('admin.produto.store');
        Route::put('/atualizar', [ProdutoController::class, 'update'])->name('admin.produto.update');

    });


    Route::prefix('clientes')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('admin.cliente.index');
        Route::get('/novo', [ClienteController::class, 'create'])->name('admin.cliente.create');
        Route::get('/{id}/editar', [ClienteController::class, 'edit'])->name('admin.cliente.edit');
        Route::post('/salvar', [ClienteController::class, 'store'])->name('admin.cliente.store');
        Route::put('/atualizar', [ClienteController::class, 'update'])->name('admin.cliente.update');

    });

    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.admin.index');
        Route::get('/novo', [AdminController::class, 'create'])->name('admin.admin.create');
        Route::get('/{id}/editar', [AdminController::class, 'edit'])->name('admin.admin.edit');
        Route::post('/salvar', [AdminController::class, 'store'])->name('admin.admin.store');
        Route::put('/atualizar', [AdminController::class, 'update'])->name('admin.admin.update');

    });


});

Route::prefix('admins')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.admin.index');
    Route::get('/novo', [AdminController::class, 'create'])->name('admin.admin.create');
    Route::get('/{id}/editar', [AdminController::class, 'edit'])->name('admin.admin.edit');
    Route::post('/salvar', [AdminController::class, 'store'])->name('admin.admin.store');
    Route::put('/atualizar', [AdminController::class, 'update'])->name('admin.admin.update');

});



Route::prefix('loja')->group(function () {

    Route::get('/limpar-carrinho', [LojaController::class, 'limparCarrinho'])->name('loja.limpar');
    Route::get('/', [LojaController::class, 'index'])->name('loja.index');
    Route::get('/{uuid}/detalhes', [LojaController::class, 'detalhes'])->name('loja.detalhes');
    Route::get('/{uuid}/{quantidade}/adicionar', [LojaController::class, 'adicionar'])->name('loja.adicionar');
    Route::get('/carrinho', [LojaController::class, 'carrinho'])->name('loja.carrinho');

});

Route::prefix('loja')->middleware(['auth'])->group(function () {
    Route::post('/fechar', [LojaController::class, 'store'])->name('loja.store');
    Route::get('/{uuid}/checkout', [LojaController::class, 'checkout'])->name('loja.checkout');
    Route::post('/{uuid}/finalizar', [LojaController::class, 'finalizar'])->name('loja.finalizar');
});
