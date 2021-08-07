<?php


use App\Http\Models\User;

User::create([
    'email' => 'admin@admin.ua',
    'username' => 'admin',
    'password' => '123',
]);
User::create([
    'email' => 'test@test.com',
    'username' => 'test',
    'password' => '123',
]);