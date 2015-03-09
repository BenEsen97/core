<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TeamspeakDatabaseStructure extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// drop tables if they exist
		
		Schema::dropIfExists('teamspeak_alias');
		Schema::dropIfExists('teamspeak_ban');
		Schema::dropIfExists('teamspeak_confirmation');
		Schema::dropIfExists('teamspeak_log');
		Schema::dropIfExists('teamspeak_registration');

		// create table structures

		Schema::create('teamspeak_alias', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('account_id')->unique()->unsigned();
			$table->string('display_name', 30);
			$table->string('notes', 255)->nullable();
			$table->timestamps();
		});

		Schema::create('teamspeak_ban', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('account_id')->unsigned()->index();
			$table->string('reason', 255);
			$table->integer('authorised_by')->unsigned();
			$table->timestamps();
			$table->timestamp('expires_at');
			$table->softDeletes();
		});

		Schema::create('teamspeak_confirmation', function($table) {
			$table->integer('registration_id')->primary()->unsigned();
			$table->string('privilege_key', 50);
			$table->timestamps();
		});

		Schema::create('teamspeak_log', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('registration_id')->unsigned()->nullable();
			$table->enum('type', ['idle_message', 'idle_poke', 'idle_kick', 'nick_warn', 'nick_kick']); // switch to enum?
			//$table->string('message', 255);
			$table->timestamps();
		});

		Schema::create('teamspeak_registration', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('account_id')->unsigned()->index();
			$table->bigInteger('registration_ip');
			$table->bigInteger('last_ip')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('last_os', 15)->nullable();
			$table->timestamp('last_bot_pm')->nullable();
			$table->string('uid', 50)->nullable();
			$table->smallInteger('dbid')->unsigned()->nullable();
			$table->enum('status', ['new', 'active', 'deleted']);
			$table->timestamps();
			$table->softDeletes();
		});

		// define relationships (foreign keys)

		Schema::table('teamspeak_alias', function($table) {
			$table->foreign('account_id')->references('account_id')->on('mship_account');
		});

		Schema::table('teamspeak_ban', function($table) {
			$table->foreign('account_id')->references('account_id')->on('mship_account');
			$table->foreign('authorised_by')->references('account_id')->on('mship_account');
		});

		Schema::table('teamspeak_confirmation', function($table) {
			$table->foreign('registration_id')->references('id')->on('teamspeak_registration');
		});

		Schema::table('teamspeak_log', function($table) {
			$table->foreign('registration_id')->references('id')->on('teamspeak_registration');
		});

		Schema::table('teamspeak_registration', function($table) {
			$table->foreign('account_id')->references('account_id')->on('mship_account');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::dropIfExists('teamspeak_alias');
		Schema::dropIfExists('teamspeak_ban');
		Schema::dropIfExists('teamspeak_confirmation');
		Schema::dropIfExists('teamspeak_log');
		Schema::dropIfExists('teamspeak_registration');
	}

}
