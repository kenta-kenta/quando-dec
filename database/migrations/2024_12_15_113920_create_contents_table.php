<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id(); // ID (int型、主キー、自動インクリメント)
            $table->text('text'); // 元データ (text型)
            $table->text('title'); // タイトル (text型)
            $table->json('structure'); // 構造化データ (json型)
            $table->datetime('created_at'); // 作成時間 (datetime型)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
};
