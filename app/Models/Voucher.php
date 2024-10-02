<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'expiry_date',
        'is_active'
    ];

    public function isExpired() {
        return $this->expiry_date < now();
    }  
}
