<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->unique()->after('id');
            $table->string('cargo')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('cargo');
            $table->string('cep')->nullable()->after('birth_date');
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable()->after('id');
            $table->string('role')->default('employee')->after('password'); // 'admin' ou 'employee'
            
            // FK self-referential (funcionário -> gestor)
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn([
                'cpf','cargo','birth_date','cep','street','number','complement',
                'neighborhood','city','state','manager_id','role'
            ]);
        });
    }
};
