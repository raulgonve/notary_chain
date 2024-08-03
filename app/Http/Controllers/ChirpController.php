<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\NotarizedDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;   
use Illuminate\Support\Facades\Auth;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Chirps/Index', [
            'chirps' => NotarizedDocument::with('user:id,name')->latest()->get(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request): RedirectResponse
    {
        //dd($request->all());
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'file' => 'required|file'
        ]);

        $documentHash = hash('sha256', file_get_contents($request->file('file')));
        $timestamp = now();
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
            $notary = $path; // Almacenar el path en lugar del hash
        }
    

        $sbt = NotarizedDocument::create([
            'document_hash' => $documentHash,
            'document_id' => $request->message,
            'timestamp' => $timestamp,
            'notary' => $notary,
            'user_id' => Auth::id(), 
        ]);

        //return response()->json(['sbt' => $sbt], 201);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //
    }
}
