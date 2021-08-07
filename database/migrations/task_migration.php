<?php


use Illuminate\Database\Capsule\Manager as Capsule;


Capsule::schema()->create('tasks', function ($table) {
    $table->increments('id');
    $table->foreignId('user_id')->referances('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
    $table->text('text');
    $table->boolean('status');
    $table->boolean('is_admined')->default(0);
    $table->timestamps();
});