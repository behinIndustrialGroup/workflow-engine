<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wf_on_credit_payments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('case_number');
            $table->string('case_id')->nullable();
            $table->string('process_id')->nullable();
            $table->string('process_name')->nullable();
            $table->string('payment_type');
            $table->unsignedBigInteger('amount')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('invoice_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wf_on_credit_payments');
    }
};
