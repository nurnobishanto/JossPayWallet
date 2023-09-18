<?php

use App\Models\Store;
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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_id', 6)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('api_key')->unique();
            $table->string('business_name');
            $table->string('business_logo')->nullable();
            $table->string('business_type')->nullable();
            $table->string('mobile_number');
            $table->string('business_email');
            $table->string('domain_name')->unique();
            $table->string('website_url')->unique();
            $table->string('server_ip')->nullable();
            $table->double('balance')->default(0.0);
            $table->double('charge')->default(2.75);
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
        // Generate store_id using model events
        Store::creating(function (Store $store) {
            $store->store_id = $this->generateStoreId();
            $store->api_key = $this->generateApiKey();
        });
    }
    private function generateStoreId()
    {
        $store_id = mt_rand(100000, 999999); // Generate random 6-digit number

        // Check if store_id already exists, generate a new one if it does
        while (Store::where('store_id', $store_id)->exists()) {
            $store_id = mt_rand(100000, 999999);
        }

        return $store_id;
    }
    private function generateApiKey()
    {
        $length = 32; // Length of the API key
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $apiKey = '';

        for ($i = 0; $i < $length; $i++) {
            $apiKey .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $apiKey;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
