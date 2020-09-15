<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyOptionsInSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('currency_symbol_position')->default(__('backend.left'));
            $table->string('thousand_separator')->default(",");
            $table->string('decimal_separator')->default(".");
            $table->string('decimal_points')->default("2");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('currency_position_symbol');
            $table->dropColumn('thousand_separator');
            $table->dropColumn('decimal_separator');
            $table->dropColumn('decimal_points');
        });
    }
}
