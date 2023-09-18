<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            // Set the default values for your columns
            $model->store_id = self::generateStoreId();
            $model->api_key = self::generateApiKey();
            $model->user_id = auth()->user()->id;
            $model->status = 'deactivated';
            $model->balance = 0;
            $model->charge = 2.5;
            // You can add more columns and their default values here
        });
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    private static function generateStoreId()
    {
        $store_id = mt_rand(100000, 999999); // Generate random 6-digit number

        // Check if store_id already exists, generate a new one if it does
        while (Store::where('store_id', $store_id)->exists()) {
            $store_id = mt_rand(100000, 999999);
        }

        return $store_id;
    }
    private static function generateApiKey()
    {
        $length = 32; // Length of the API key
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $apiKey = '';

        for ($i = 0; $i < $length; $i++) {
            $apiKey .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $apiKey;
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
