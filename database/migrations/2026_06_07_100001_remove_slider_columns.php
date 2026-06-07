<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['title', 'title_en', 'description', 'description_en', 'link', 'link_text', 'link_text_en', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->string('link')->nullable();
            $table->string('link_text')->nullable();
            $table->string('link_text_en')->nullable();
            $table->integer('sort_order')->default(0);
        });
    }
};