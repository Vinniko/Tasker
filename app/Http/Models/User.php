<?php


namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'email',
        'username',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}