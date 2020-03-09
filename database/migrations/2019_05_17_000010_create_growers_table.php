<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('growers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
        DB::table('growers')->insert(
            [
                [
                    'description' => "We're a family owned orchard based in Tasman.\nWe have a large amount of blueberry and cherry trees."
                ],
                [
                    'description' => "We're a family owned orchard based in Nelson.\nWe have a large amount of raspberry and strawberry plants."
                ],
                [
                    'description' => "This is the seller page for Nelson Strawberries.\nWe produce a large portion of the region's strawberries."
                ],
                [
                    'description' => "We're a family owned orchard based in Nelson.\nWe have a large amount of blueberry and cherry trees."
                ],
                [
                    'description' => "We're a family owned orchard based in Tasman.\nWe have a large amount of cherry trees."
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
        Schema::dropIfExists('growers');
    }
}
