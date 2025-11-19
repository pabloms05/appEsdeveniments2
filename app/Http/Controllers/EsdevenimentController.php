<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esdeveniment;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;

class EsdevenimentController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categoria::all();
        $esdeveniments = Esdeveniment::query();

        if ($request->filled('categoria')) {
            $esdeveniments->where('categoria_id', $request->categoria);
        }

        if (Auth::check() && Auth::user()->birth_date) {
            $birthDate = new \DateTime(Auth::user()->birth_date);
            $today = new \DateTime('today');
            $edat = $birthDate->diff($today)->y;
            $esdeveniments->where('edat_minima', '<=', $edat);
        }

        $esdeveniments = $esdeveniments->get();

        return view('esdeveniments.index', compact('esdeveniments', 'categories'));
    }

    // Mostrar detall d’un esdeveniment
    public function show($id)
    {
        $esdeveniment = Esdeveniment::with('categoria')->findOrFail($id);

        return view('esdeveniments.show', compact('esdeveniment'));
    }

    public function reserva($id)
    {
        $esdeveniment = Esdeveniment::findOrFail($id);

        // Comprova que encara hi ha places disponibles
        if ($esdeveniment->reserves < $esdeveniment->max_assistents) {
            $esdeveniment->increment('reserves');
            return redirect()->route('esdeveniments.show', $esdeveniment->id)
                ->with('success', 'Reserva realitzada correctament!');
        } else {
            return redirect()->route('esdeveniments.show', $esdeveniment->id)
                ->with('error', 'No queden places disponibles.');
        }
    }

    public function create()
    {
        $categories = Categoria::all();
        return view('esdeveniments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'data' => 'required|date',
            'hora' => 'required',
            'descripcio' => 'required|string',
            'edat_minima' => 'required|integer|min:0',
            'imatge' => 'nullable|image',
            'max_assistents' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('imatge')) {
            $imatge = $request->file('imatge')->move(public_path('images/esdeveniments'), $request->file('imatge')->getClientOriginalName());
            $validated['imatge'] = $request->file('imatge')->getClientOriginalName();
        }

        $validated['reserves'] = 0;
        Esdeveniment::create($validated);

        return redirect()->route('esdeveniments.index')->with('success', 'Esdeveniment creat correctament!');
    }

    public function edit($id)
    {
        $categories = Categoria::all();
        $esdeveniment = Esdeveniment::findOrFail($id);

        // with('categoria')->

        return view('esdeveniments.edit', compact('esdeveniment', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'data' => 'required|date',
            'hora' => 'required',
            'descripcio' => 'required|string',
            'edat_minima' => 'required|integer|min:0',
            'imatge' => 'nullable|image',
            'max_assistents' => 'required|integer|min:1',
        ]);

        $esdeveniment = Esdeveniment::findOrFail($id);

        // Si s'ha pujat una nova imatge, actualitza-la
        if ($request->hasFile('imatge')) {
            // $imatge = $request->file('imatge')->store('images/esdeveniments', 'public');
            // $validated['imatge'] = basename($imatge);
            $imatge = $request->file('imatge')->move(public_path('images/esdeveniments'), $request->file('imatge')->getClientOriginalName());
            $validated['imatge'] = $request->file('imatge')->getClientOriginalName();
        }

        $esdeveniment->update($validated);

        // Redirigeix a l'índex amb missatge d'èxit
        return redirect()->route('esdeveniments.index')->with('success', 'Esdeveniment actualitzat correctament!');
    }

    public function destroy($id)
    {
        $esdeveniment = Esdeveniment::findOrFail($id);
        $esdeveniment->delete();
        return redirect()->route('esdeveniments.index')->with('success', 'Esdeveniment eliminat correctament!');
    }
}
