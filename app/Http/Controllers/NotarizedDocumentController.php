<?php

namespace App\Http\Controllers;

use App\Models\NotarizedDocument;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class NotarizedDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Documentos/Index', [
            'documentos' => NotarizedDocument::with('user:id,name')->where('user_id',Auth::id())->latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'document_id'   => 'required|string|max:255',
            'file' => 'required|file',
            'notary' => 'required|string',
            'document_hash' => 'required|string',
            'txid' => 'required|string',
        ]);

        $timestamp = now();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('documents', 'public');
            $ruta = $path; // Almacenar el path
        }

        NotarizedDocument::create([
            'descripcion'   => $request->descripcion,
            'document_hash' => $request->document_hash,
            'document_id' => $request->document_id,
            'timestamp' => $timestamp,
            'notary' => $request->notary,
            'ruta' => $ruta,
            'txid' => $request->txid,
            'user_id' => Auth::id(),
        ]);

        return redirect(route('documentos.index'));
    }

    public function verificar(): Response
    {
        return Inertia::render('Documentos/Verificar');
    }
}
