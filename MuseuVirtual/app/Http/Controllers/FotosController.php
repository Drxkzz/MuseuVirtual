<?php

namespace App\Http\Controllers;

use App\Models\Fotos;
use App\Models\Jazida;
use App\Models\Mineral;
use App\Models\Rocha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use App\Models\AnotacaoFoto;
class FotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fotos = Fotos::with(['rocha', 'mineral', 'jazida', 'anotacoes'])->get();
        return Inertia::render('Dashboard/Fotos/Index', ['fotos' => $fotos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rochas = Rocha::all();
        $minerais = Mineral::all();
        $jazidas = Jazida::all();
        $idRocha = request('idRocha'); // captura o valor da query string

        # return view('dashboard.fotos.create', compact('rochas', 'minerais', 'jazidas', 'idRocha'));
        return Inertia::render('Dashboard/Fotos/Create', ['rochas'=>$rochas, 'minerais'=> $minerais, 'jazidas'=>$jazidas, 'idRochas'=>$idRocha]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $diretorio = 'fotos/geral';
        $atributos = [];


        if ($request->filled('idRocha')) {
            $atributos['idRocha'] = $request->idRocha;
            $diretorio = 'fotos/rochas';
        } elseif ($request->filled('idMineral')) {
            $atributos['idMineral'] = $request->idMineral;
            $diretorio = 'fotos/minerais';
        } elseif ($request->filled('idJazida')) {
            $atributos['idJazida'] = $request->idJazida;
            $diretorio = 'fotos/jazidas';
        }


        if ($request->hasFile('foto')) {
            $nomeCapa = $request->input('capa_nome');
            
            foreach ($request->file('foto') as $arquivo) {
                $foto = new Fotos($atributos);

                $nomeOriginal = $arquivo->getClientOriginalName();
                $nomeFinal = time() . "_" . $nomeOriginal;

                $caminho = $arquivo->storeAs($diretorio, $nomeFinal, 'public');
                $foto->caminho = $caminho;

                // Compara o nome original para marcar como capa
                $foto->capa = ($nomeOriginal === $nomeCapa) ? 1 : 0;

                $foto->save();
            }

        }
        if (! in_array($request->tipo, ['1','2','3'])){
            return redirect()->route('fotos-index')->with('success', 'Fotos enviadas com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Fotos $fotos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fotos = Fotos::with('anotacoes')->findOrFail($id);

        return Inertia::render('Dashboard/Fotos/Edit', [
            'fotos' => $fotos
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $foto = Fotos::findOrFail($id);
        // Atualiza campo de capa

        $capa = $request->capa != null && $request->capa != "0" ? 1 : 0;

        if ($capa) {
            // Remove marcação de outras capas
            Fotos::where('capa', 1)->update(['capa' => 0]);
        }

        $data = [
            'idRocha' => $request->idRocha,
            'idMineral' => $request->idMineral,
            'idJazida' => $request->idJazida,
            'capa' => $capa,
        ];

        // Se uma nova foto foi enviada
        if ($request->hasFile('foto')) {
            // Exclui o arquivo antigo
            File::delete('storage/' . $foto->caminho);

            $arquivo = $request->file('foto');
            $nomeOriginal = $arquivo->getClientOriginalName();
            $nomeFinal = time() . '_' . $nomeOriginal;

            // Decide em qual pasta salvar
            if ($request->filled('idRocha')) {
                $diretorio = 'fotos/rochas';
            } elseif ($request->filled('idMineral')) {
                $diretorio = 'fotos/minerais';
            } elseif ($request->filled('idJazida')) {
                $diretorio = 'fotos/jazidas';
            } else {
                $diretorio = 'fotos/geral';
            }

            // Salva o novo arquivo
            $caminho = $arquivo->storeAs($diretorio, $nomeFinal, 'public');
            $data['caminho'] = $caminho;
        }

        // Atualiza os dados no banco
        $foto->update($data);

        return redirect()->back()->with('success', 'Foto atualizada com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {   
        $foto = Fotos::findOrFail($id);
        $caminhoFoto = $foto->caminho;
        // Remover o arquivo físico, se existir
        if (File::exists(public_path('storage/' . $caminhoFoto))) {
            File::delete('storage/' . $caminhoFoto);
        }
        
        $foto->delete();

        return redirect()->back();
    }


    public function salvarAnotacoes(Request $request, $fotoId)
    {
        $anotacoes = $request->input('anotacoes', []);
        $deletadas = $request->input('deletadas', []);

        // Deletar as anotações marcadas para exclusão
        if (!empty($deletadas)) {
            AnotacaoFoto::whereIn('id', $deletadas)->delete();
        }

        foreach ($anotacoes as $anotacao) {
            if (isset($anotacao['id']) && $anotacao['id']) {
                // Atualiza anotação existente
                $registro = AnotacaoFoto::find($anotacao['id']);
                if ($registro) {
                    $registro->update([
                        'x' => $anotacao['x'],
                        'y' => $anotacao['y'],
                        'texto' => $anotacao['texto'],
                    ]);
                }
            } else {
                // Cria nova anotação
                AnotacaoFoto::create([
                    'foto_id' => $fotoId,
                    'x' => $anotacao['x'],
                    'y' => $anotacao['y'],
                    'texto' => $anotacao['texto'],
                ]);
            }
        }

    }
}
