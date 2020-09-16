<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePublishedInNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dateTime("published_at")
                ->nullable()
                ->comment("Дата публикации");
        });
        if (class_exists(\App\News::class)) {
            foreach (\App\News::all() as $item) {
                if ($item->published) {
                    $item->published_at = $item->updated_at;
                    $item->save();
                }
            }
        }
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn("published");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->boolean("published")
                ->default(1)
                ->after("slug")
                ->comment("Статус публикации");
        });
        if (class_exists(\App\News::class)) {
            foreach (\App\News::all() as $item) {
                $item->published = ! empty($item->published_at) ? 1 : 0;
                $item->save();
            }
        }
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn("published_at");
        });
    }
}
