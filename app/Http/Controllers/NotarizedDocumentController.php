<?php

namespace App\Http\Controllers;

use App\Models\NotarizedDocument;
use Illuminate\Http\Request;

class NotarizedDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NotarizedDocument $notarizedDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotarizedDocument $notarizedDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotarizedDocument $notarizedDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotarizedDocument $notarizedDocument)
    {
        //
    }

    public function emitSBT(Request $request)
    {
        $request->validate([
            'document' => 'required|file',
            'document_id' => 'required|string',
            'notary' => 'required|string',
        ]);

        $documentHash = hash('sha256', file_get_contents($request->file('document')));
        $timestamp = now();

        $sbt = NotarizedDocument::create([
            'document_hash' => $documentHash,
            'document_id' => $request->document_id,
            'timestamp' => $timestamp,
            'notary' => $request->notary,
        ]);

        return response()->json(['sbt' => $sbt], 201);
    }

    public function verifySBT(Request $request)
    {
        $request->validate([
            'document' => 'required|file',
            'document_id' => 'required|string',
        ]);

        $documentHash = hash('sha256', file_get_contents($request->file('document')));
        $sbt = NotarizedDocument::where('document_hash', $documentHash)
            ->where('document_id', $request->document_id)
            ->first();

        if ($sbt) {
            return response()->json(['verified' => true, 'sbt' => $sbt], 200);
        } else {
            return response()->json(['verified' => false], 404);
        }
    }
}
