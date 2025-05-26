<?php

namespace App\Http\Controllers;
use App\Models\Mineral;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // Para type-hinting de retorno
use Illuminate\Http\JsonResponse; // Para type-hinting de retorno de API
class MineralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $minerais = Mineral::with('fotos')->get();
        // dd($minerais);
        return view('dashboard.minerais.index', compact('minerais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.minerais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mineral = new Mineral;
        $mineral -> nome = $request -> nome;
        $mineral -> descricao = $request -> descricao;
        $mineral -> propriedades = $request -> propriedades;
        $mineral -> save();
        
        if ($request->hasFile('foto')) {
            $fotosRequest = new Request([
                "idMineral" => $mineral->id,
                "capa_nome" => $request->input('capa_nome'),
            ]);

            // Encaminha os arquivos
            $fotosRequest->files->set('foto', $request->file('foto'));

            // Chama o controller de fotos
            app(\App\Http\Controllers\FotosController::class)->store($fotosRequest);
        }
        return redirect('/minerais/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mineral $mineral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mineral = Mineral::findOrFail($id);
        return view('dashboard.minerais.edit', compact('mineral'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mineral = Mineral::findOrFail($id);  // Buscar o mineral, antes de alterar os dados
        $mineral -> nome = $request -> nome;
        $mineral -> descricao = $request -> descricao;
        $mineral -> propriedades = $request -> propriedades;
        $mineral -> save();
        return redirect('/minerais/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($mineral)
    {
        $mineral = Mineral::findOrFail($mineral);  // Buscar o mineral, antes de alterar os dados
        foreach ($mineral->fotos as $foto) {
            app(\App\Http\Controllers\FotosController::class)->destroy($foto->id);

        }
        
        $mineral->delete();
        $minerais = Mineral::paginate(10);  // 10 rochas por página

        return redirect()->route('minerais.index', 'minerals')->with('success', 'Mineral deletado com sucesso!');
    }


}
