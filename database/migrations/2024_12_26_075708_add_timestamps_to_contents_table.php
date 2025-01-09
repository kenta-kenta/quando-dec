<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->datetime('updated_at')->nullable(); // updated_atをnullableで追加
        });

        Schema::table('contents', function (Blueprint $table) {
            $table->string('title')->nullable()->change(); // titleをnullableに変更
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('updated_at'); // updated_atのみを削除
        });

        Schema::table('contents', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change(); // titleを非nullableに戻す
        });
    }
};
