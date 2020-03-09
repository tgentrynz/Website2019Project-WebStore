<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVarietiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('varieties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('fruit');
            $table->timestamps();
            $table->foreign('fruit')->references('id')->on('fruits');
        });
        DB::table('varieties')->insert(
            [
                [
                    'name' => 'Honeoye',
                    'fruit' => 1
                ],
                [
                    'name' => 'Earliglow',
                    'fruit' => 1
                ],
                [
                    'name' => 'Allstar',
                    'fruit' => 1
                ],
                [
                    'name' => 'Ozark',
                    'fruit' => 1
                ],

                [
                    'name' => 'Boyne',
                    'fruit' => 2
                ],
                [
                    'name' => 'Anne',
                    'fruit' => 2
                ],
                [
                    'name' => 'Dorman Red',
                    'fruit' => 2
                ],
                [
                    'name' => 'Jewel',
                    'fruit' => 2
                ],

                [
                    'name' => 'Bluecrop',
                    'fruit' => 3
                ],
                [
                    'name' => 'Polaris',
                    'fruit' => 3
                ],
                [
                    'name' => 'Toro',
                    'fruit' => 3
                ],
                [
                    'name' => 'Jubilee',
                    'fruit' => 3
                ],

                [
                    'name' => 'Bing',
                    'fruit' => 4
                ],
                [
                    'name' => 'Burlat',
                    'fruit' => 4
                ],
                [
                    'name' => 'Compact Stella',
                    'fruit' => 4
                ],
                [
                    'name' => 'Dawson',
                    'fruit' => 4
                ]
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
        Schema::dropIfExists('varieties');
    }
}
