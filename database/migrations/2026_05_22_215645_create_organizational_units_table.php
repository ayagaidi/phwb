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
        Schema::create('organizational_units', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Arabic name
            $table->string('name_en')->nullable();     // English name
            $table->string('title')->nullable();       // Position/Title Arabic
            $table->string('title_en')->nullable();    // Position/Title English
            $table->string('photo')->nullable();       // Person photo
            $table->foreignId('parent_id')->nullable()->constrained('organizational_units')->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizational_units');
    }
};
