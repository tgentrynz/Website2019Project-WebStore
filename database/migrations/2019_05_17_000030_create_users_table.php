<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('grower')->nullable();
            $table->unsignedBigInteger('customer')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('grower')->references('id')->on('growers');
            $table->foreign('customer')->references('id')->on('customers');
        });
        DB::table('users')->insert(
            [
                [
                    'name' => 'Hey! Berries!',
                    'image' => 'samplegrower1',
                    'email' => 'grower1@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'grower' => 1,
                ],
                [
                    'name' => 'Tasman Berry',
                    'image' => 'samplegrower2',
                    'email' => 'grower2@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'grower' => 2,
                ],
                [
                    'name' => 'Nelson Strawberries',
                    'image' => 'samplegrower3',
                    'email' => 'grower3@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'grower' => 3,
                ],
                [
                    'name' => 'Isaac\'s Farm',
                    'image' => 'samplegrower4',
                    'email' => 'grower4@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'grower' => 4,
                ],
                [
                    'name' => 'Rasberry Collective',
                    'image' => 'samplegrower5',
                    'email' => 'grower5@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'grower' => 5,
                ],
            ]
        );
        DB::table('users')->insert(
            [
                [
                    'name' => 'customer1',
                    'email' => 'customer1@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'customer' => 1,
                ],
                [
                    'name' => 'customer2',
                    'email' => 'customer2@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'customer' => 2,
                ],
                [
                    'name' => 'customer3',
                    'email' => 'customer3@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'customer' => 3,
                ],
                [
                    'name' => 'customer4',
                    'email' => 'customer4@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'customer' => 4,                    
                ],
                [
                    'name' => 'customer5',
                    'email' => 'customer5@ibganelson.co.nz',
                    'password' => '$2y$10$BnoKs7LLKjEaAQmvqqBYAeMpwcSHOACY7c4ueF4zfsr2Ix2FMxzGG',
                    'customer' => 5,                    
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
