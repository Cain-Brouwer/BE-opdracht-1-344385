<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('products', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name', 45);

            $table->mediumText('description');

            $table->unsignedInteger('category_id');

            $table->foreign('category_id')

                ->references('id')

                ->on('categories');

        });

    }

    public function down(): void
    {

        Schema::dropIfExists('products');

    }
};
