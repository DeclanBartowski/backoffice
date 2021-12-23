<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variant_blocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('preview')->nullable();
            $table->json('tariffs')->nullable();
            $table->longText('detail')->nullable();
            $table->longText('detail_actual')->nullable();
            $table->integer('number');
            $table->enum('status', ['draft', 'public']);
            $table->foreignId('block_id');
            $table->foreign('block_id')->references('id')->on('blocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variant_blocks');
    }
}
