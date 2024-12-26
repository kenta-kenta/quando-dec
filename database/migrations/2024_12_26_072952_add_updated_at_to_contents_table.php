<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedAtToContentsTable extends Migration
{
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->timestamp('updated_at')->nullable()->after('created_at'); // updated_atカラムを追加
        });
    }

    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('updated_at'); // 変更を元に戻す場合にカラムを削除
        });
    }
}

