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
        Schema::table('incidents', function (Blueprint $table) {
            $table->string('status')->nullable(); // urgência
            $table->string('incident')->nullable(); // problema
            $table->string('entity')->nullable();   // pode ser nulo
            $table->integer('counter')->default(1); // inicia em 1
        });
    }

    public function down()
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['status', 'incident', 'entity', 'counter']);
        });
    }

};
