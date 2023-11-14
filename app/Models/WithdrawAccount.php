<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawAccount extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'bank_name','account_name','account_no', 'branch_name', 'routing_no','account_type', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
