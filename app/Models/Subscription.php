<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
    {
        use HasFactory;

        protected $fillable = [
            'user_id',
            'package_name',
            'price',
            'payment_method',
            'status',
            'paid_at',
        ];

        protected $casts = [
            'paid_at' => 'datetime',
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }
