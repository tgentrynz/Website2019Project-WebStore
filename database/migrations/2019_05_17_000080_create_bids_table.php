<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer');
            $table->unsignedBigInteger('auction');
            $table->decimal('value', 12, 2);
            $table->foreign('customer')->references('id')->on('customers');
            $table->foreign('auction')->references('id')->on('auctions');
            $table->timestamps();
        });
        DB::table('bids')->insert(
            [
                [
                    'customer' => 1,
                    'auction' => 1,
                    'value' => 11.00,
                ],
                [
                    'customer' => 2,
                    'auction' => 1,
                    'value' => 11.50,
                ],
                [
                    'customer' => 1,
                    'auction' => 2,
                    'value' => 11.50,
                ],
                [
                    'customer' => 1,
                    'auction' => 3,
                    'value' => 11.50,
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
        Schema::dropIfExists('bids');
    }
}
