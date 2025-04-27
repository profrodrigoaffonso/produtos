<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\Produto;
use App\Models\Categoria;
use App\Helpers\Helpers;

class ProdutoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        $produtos = Produto::lista(array('produtos.id','produtos.uuid','produtos.nome','produtos.valor','categorias.nome AS categoria'), 'produtos.nome', 'ASC', 20);
        return view('admin.produtos.index', compact('produtos'));
    }

    public function exportar(){

        $produtos = Produto::listaExport();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "ID");
        $sheet->setCellValue('B1', "Nome");
        $sheet->setCellValue('C1', "Categoria");
        $sheet->setCellValue('D1', "Valor");

        $i = 2;

        foreach ($produtos as $key => $produto) {

            $sheet->setCellValue('A' . $i, $produto->id);
            $sheet->setCellValue('B' . $i, $produto->nome);
            $sheet->setCellValue('C' . $i, $produto->categoria);
            $sheet->setCellValue('D' . $i, $produto->valor);

            $i++;
        }

        $writer = new Xlsx($spreadsheet);

        $file = "excel/".sha1(uniqid()).".xlsx";
        $writer->save($file);

        $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        return response()->download($file, 'Produtos_' . date('YmdHis') . '.xlsx', $headers)->deleteFileAfterSend(true);

    }

    public function importar(){
        return view('admin.produtos.importar');
    }

    public function upload(Request $request)
    {
        $arquivo = $request->file('arquivo');

        $nome = uniqid() . '.xlsx';

        if (move_uploaded_file($arquivo->getPathname(), 'uploads/' . $nome)) {

            // Carrega o arquivo
            $spreadsheet = IOFactory::load('uploads/' . $nome);

            // Pega a primeira aba ativa
            $sheet = $spreadsheet->getActiveSheet();

            // Lê todas as linhas como array
            $dados = $sheet->toArray();

            $categorias = Categoria::pluck('id', 'nome')->toArray();

            unset($dados[0]);

            foreach($dados as $row){

                $categoria_id = $categorias[mb_strtoupper($row[1])];

                $verificar = Produto::where('nome', mb_strtoupper($row[0]))->first();

                if(!$verificar){
                    Produto::create([
                        'nome'                  => mb_strtoupper($row[0]),
                        'uuid'                  => sha1(uniqid()),
                        'categoria_id'          => $categoria_id,
                        'valor'                 => str_replace(',', '.', $row[2])
                    ]);
                }

            }

            unlink('uploads/' . $nome);

            return redirect(route('admin.produto.index'));

        } else {
            echo "Possível ataque de upload de arquivo!\n";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        $categoriasCombo = Categoria::comboCategorias();
        return view('admin.produtos.create', compact('categoriasCombo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = sha1(uniqid());
        $dados = Helpers::formataBase($dados);
        $dados['valor'] = Helpers::formataValor($dados['valor'],'.');
        Produto::create($dados);
        return redirect(route('admin.produto.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        $produto = Produto::buscaUuid($uuid);
        $categoriasCombo = Categoria::comboCategorias();
        return view('admin.produtos.edit', compact('produto','categoriasCombo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $dados = $request->all();
        $produto = Produto::buscaUuid($dados['uuid']);
        $dados = Helpers::formataBase($dados);
        $dados['id'] = $produto->id;
        $dados['valor'] = Helpers::formataValor($dados['valor'],'.');
        $produto->update($dados);
        return redirect(route('admin.produto.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        //
    }
}
