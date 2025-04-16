<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->bigInteger('employee_type_id')->unsigned()->nullable();
            $table->bigInteger('employee_nationality_id')->unsigned()->nullable();
            $table->bigInteger('employee_religion_id')->unsigned()->nullable();
            $table->bigInteger('employee_marital_status_id')->unsigned()->nullable();
            $table->date('birthdate')->nullable();
            $table->string('mobile')->nullable();
            $table->bigInteger('employee_identity_type_id')->unsigned()->nullable();
            $table->string('identity_num')->nullable();
            $table->bigInteger('employee_card_issuer_id')->unsigned()->nullable();
            $table->date('release_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable();

            $table->foreign('employee_type_id')->references('id')->on('employee_types')->onDelete('set null');
            $table->foreign('employee_nationality_id')->references('id')->on('employee_nationalities')->onDelete('set null');
            $table->foreign('employee_religion_id')->references('id')->on('employee_religions')->onDelete('set null');
            $table->foreign('employee_marital_status_id')->references('id')->on('employee_marital_status')->onDelete('set null');
            $table->foreign('employee_identity_type_id')->references('id')->on('employee_identity_types')->onDelete('set null');
            $table->foreign('employee_card_issuer_id')->references('id')->on('employee_card_issuers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['employee_type_id']);
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['employee_nationality_id']);
            $table->dropForeign(['employee_religion_id']);
            $table->dropForeign(['employee_marital_status_id']);
            $table->dropForeign(['employee_identity_type_id']);
            $table->dropForeign(['employee_card_issuer_id']);

            $table->dropColumn([
                'employee_type_id',
                'branch_id',
                'employee_nationality_id',
                'employee_religion_id',
                'employee_marital_status_id',
                'birthdate',
                'mobile',
                'employee_identity_type_id',
                'identity_num',
                'employee_card_issuer_id',
                'release_date',
                'expiry_date',
                'salary',
                'commission_rate',
            ]);
        });
    }
};