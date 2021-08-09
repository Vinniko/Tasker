<?php


namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'username',
        'email',
        'text',
        'status',
        'is_admined',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
}
