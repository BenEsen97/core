<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFailedPosrepColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smartcars_pirep', function (Blueprint $table) {
            $table->integer('failed_at')->after('pass_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smartcars_pirep', function (Blueprint $table) {
            $table->dropColumn('failed_at');
        });
    }
}
