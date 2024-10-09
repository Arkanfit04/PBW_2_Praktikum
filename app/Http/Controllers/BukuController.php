<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     return view('buku/index', [ 
    'bukus' => DB::table('bukus')->get()
    ]);
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     return view('buku/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        $ValidatedData = $request->validate([

            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required',
            'sampul' => 'required|image|file|max:2048',
        ]);
        
        if ($request->file('sampul')) {
            $validatedData['sampul'] = $request->file('sampul')->store('/sampul-buku');
        }
        
        Buku::create($validatedData);
        
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $id)
    {
        $buku = Buku::find($id);

        if ($buku === null) {
            return redirect()->route('bukus.index')->withErrors(['message' => 'Buku tidak ditemukan.']);
        }
    
        return view('buku/update', compact('buku'));
            
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, Buku $buku)
    {
        $ValidatedData = $request->validated([

            'judul' => 'required',
            'penulis' => 'required',
            'kategori' => 'required',
            'sampul' => 'image|file|max:2048',
        ]);

        if ($request->files('sampul')) {
            if ($request->sampulLama) {
                Storage::delete($request->sampulLama);
            }
            $ValidatedData['sampul'] = $request->file('sampul')->store('/sampul-buku');
        }
        Buku::where('id', $buku)->update($ValidatedData);
        return redirect('/buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $test = DB::table('bukus')->select('sampul')
        ->where('id', $buku)
        ->get();
    if ($test[0]->sampul) {
        Storage::delete($test[0]->sampul);
    }
    Buku::destroy($buku);
    return redirect('/buku');
    }
}


