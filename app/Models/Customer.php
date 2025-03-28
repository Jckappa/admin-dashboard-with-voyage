<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'age', 'gender', 'marital_status', 'occupation', 'monthly_income',
        'educational_qualifications', 'family_size', 'latitude', 'longitude',
        'pin_code', 'order_status', 'feedback'
    ];
}
