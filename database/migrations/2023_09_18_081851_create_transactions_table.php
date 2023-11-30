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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('tran_id')->unique();
            $table->string('success_url');
            $table->string('fail_url');
            $table->string('cancel_url');
            $table->double('amount');

            $table->string('pg_service_charge_bdt')->nullable();
            $table->string('amount_original')->nullable();
            $table->string('gateway_fee')->nullable();
            $table->string('pg_card_bank_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_holder')->nullable();
            $table->string('pay_status')->nullable();
            $table->string('card_type')->nullable();
            $table->double('store_amount')->nullable();
            $table->double('customer_store_amount')->nullable();
            $table->double('payment_charge')->nullable();
            $table->string('bank_txn')->nullable();
            $table->string('currency');
            $table->string('desc');
            $table->string('cus_name');
            $table->string('cus_email');
            $table->string('cus_add1');
            $table->string('cus_add2');
            $table->string('cus_city');
            $table->string('cus_state');
            $table->string('cus_country');
            $table->string('cus_phone');

            $table->string('cus_postcode')->nullable();
            $table->string('cus_fax')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('ship_add1')->nullable();
            $table->string('ship_add2')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_state')->nullable();
            $table->string('ship_postcode')->nullable();
            $table->string('ship_country')->nullable();


            $table->string('opt_a')->nullable();
            $table->string('opt_b')->nullable();
            $table->string('opt_c')->nullable();
            $table->string('opt_d')->nullable();
            $table->string('type')->nullable();
            $table->string('mer_txnid')->nullable();
            $table->string('status_code')->nullable();
            $table->string('method')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
