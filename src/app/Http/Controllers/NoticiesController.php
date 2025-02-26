<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Hotel;
use App\Models\NoticiaFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NoticiesController extends Controller
{
    public function index()
    {
        $noticies = Noticia::with('fotos')->orderBy('created_at', 'desc')->get();
        return view('hotel.noticies', compact('noticies'));
    }

    public function create()
    {
        $hotels = Hotel::all();
        return view('hotel.afegirNoticia', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titol' => 'required|string|max:30',
            'descripcio-curta' => 'required|string|max:40',
            'descripcio-llarga' => 'required|string',
            'publicada' => 'sometimes|boolean',
            'hotels' => 'array',
            'hotels.*' => 'exists:hotels,id',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::transaction(function () use ($validatedData, $request) {
            $noticia = Noticia::create([
                'titol' => $validatedData['titol'],
                'descripcio_curta' => $validatedData['descripcio-curta'],
                'descripcio_llarga' => $validatedData['descripcio-llarga'],
                'publicada' => $request->boolean('publicada'),
            ]);

            if ($request->has('hotels')) {
                $noticia->hotels()->sync($validatedData['hotels']);
            }

            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
                    $foto->storeAs('noticies', $filename, 'public');

                    NoticiaFoto::create(['noticia_id' => $noticia->id, 'foto' => $filename]);
                }
            }
        });

        return redirect()->route('hotel.noticies')->with('success', 'Notícia creada correctament');
    }

    public function edit($id)
    {
        $noticia = Noticia::with('fotos')->findOrFail($id);
        $hotels = Hotel::all();
        return view('hotel.editarNoticia', compact('noticia', 'hotels'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titol' => 'required|string|max:30',
            'descripcio-curta' => 'required|string|max:40',
            'descripcio-llarga' => 'required|string',
            'publicada' => 'sometimes|boolean',
            'hotels' => 'array',
            'hotels.*' => 'exists:hotels,id',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'eliminar_fotos' => 'array',
            'eliminar_fotos.*' => 'exists:noticies_foto,id',
        ]);

        DB::transaction(function () use ($validatedData, $request, $id) {
            $noticia = Noticia::findOrFail($id);
            $noticia->update([
                'titol' => $validatedData['titol'],
                'descripcio_curta' => $validatedData['descripcio-curta'],
                'descripcio_llarga' => $validatedData['descripcio-llarga'],
                'publicada' => $request->boolean('publicada'),
            ]);

            if ($request->has('hotels')) {
                $noticia->hotels()->sync($validatedData['hotels']);
            }

            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
                    $foto->storeAs('noticies', $filename, 'public');

                    NoticiaFoto::create(['noticia_id' => $noticia->id, 'foto' => $filename]);
                }
            }

            if ($request->has('eliminar_fotos')) {
                foreach ($request->input('eliminar_fotos') as $fotoId) {
                    $foto = NoticiaFoto::findOrFail($fotoId);
                    Storage::delete('public/noticies/' . $foto->foto);
                    $foto->delete();
                }
            }
        });

        return redirect()->route('hotel.noticies')->with('success', 'Notícia actualitzada correctament');
    }

    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);
        DB::transaction(function () use ($noticia) {
            foreach ($noticia->fotos as $foto) {
                Storage::delete('public/noticies/' . $foto->foto);
                $foto->delete();
            }
            $noticia->delete();
        });

        return redirect()->route('hotel.noticies')->with('success', 'Notícia eliminada correctament');
    }

    public function publicar($id)
    {
        $noticia = Noticia::findOrFail($id);
        $noticia->update(['publicada' => true]);

        return redirect()->route('hotel.noticies')->with('success', 'Notícia publicada correctament');
    }
}
