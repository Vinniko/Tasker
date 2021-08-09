<?php


use Illuminate\Database\Capsule\Manager as Capsule;


Capsule::schema()->create('tasks', function ($table) {
    $table->increments('id');
    $table->string('username');
    $table->string('email');
    $table->text('text');
    $table->boolean('status');
    $table->boolean('is_admined')->default(0);
    $table->timestamps();
});
