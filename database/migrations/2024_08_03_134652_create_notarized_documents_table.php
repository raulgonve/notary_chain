<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notarized_documents', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('document_hash');
            $table->string('document_id');
            $table->string('notary');
            $table->string('ruta');
            $table->string('txid');
            $table->timestamp('timestamp');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notarized_documents');
    }
};
