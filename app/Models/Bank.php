<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['bank_name', 'bank_type','image'];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
