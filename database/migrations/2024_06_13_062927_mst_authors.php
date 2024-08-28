<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('mst_authors', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name', 10)->unique();
            $table->string('bio', 100)->nullable();
            $table->date('birth_date');
        });
    }

    public function down(): void
    {
        //
    }
};
