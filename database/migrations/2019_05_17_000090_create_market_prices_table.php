<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->unsignedBigInteger('variety');
            $table->unsignedBigInteger('grade');
            $table->decimal('value', 12, 2);
            $table->primary(['variety', 'grade']);
        });
        DB::table('market_prices')->insert(
            [
                [
                    'variety' => 1,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 1,
                    'grade' => 2,
                    'value' => 6
                ],
                [
                    'variety' => 1,
                    'grade' => 3,
                    'value' => 2
                ],

                [
                    'variety' => 2,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 2,
                    'grade' => 2,
                    'value' => 8
                ],
                [
                    'variety' => 2,
                    'grade' => 3,
                    'value' => 2
                ],

                [
                    'variety' => 3,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 3,
                    'grade' => 2,
                    'value' => 11
                ],
                [
                    'variety' => 3,
                    'grade' => 3,
                    'value' => 6
                ],

                [
                    'variety' => 4,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 4,
                    'grade' => 2,
                    'value' => 16
                ],
                [
                    'variety' => 4,
                    'grade' => 3,
                    'value' => 4
                ],

                [
                    'variety' => 5,
                    'grade' => 1,
                    'value' => 21
                ],
                [
                    'variety' => 5,
                    'grade' => 2,
                    'value' => 15
                ],
                [
                    'variety' => 5,
                    'grade' => 3,
                    'value' => 6
                ],

                [
                    'variety' => 6,
                    'grade' => 1,
                    'value' => 1
                ],
                [
                    'variety' => 6,
                    'grade' => 2,
                    'value' => 11
                ],
                [
                    'variety' => 6,
                    'grade' => 3,
                    'value' => 1
                ],

                [
                    'variety' => 7,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 7,
                    'grade' => 2,
                    'value' => 11
                ],
                [
                    'variety' => 7,
                    'grade' => 3,
                    'value' => 11
                ],

                [
                    'variety' => 8,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 8,
                    'grade' => 2,
                    'value' => 6
                ],
                [
                    'variety' => 8,
                    'grade' => 3,
                    'value' => 5
                ],

                [
                    'variety' => 9,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 9,
                    'grade' => 2,
                    'value' => 5
                ],
                [
                    'variety' => 9,
                    'grade' => 3,
                    'value' => 1
                ],

                [
                    'variety' => 10,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 10,
                    'grade' => 2,
                    'value' => 9
                ],
                [
                    'variety' => 10,
                    'grade' => 3,
                    'value' => 7
                ],

                [
                    'variety' => 11,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 11,
                    'grade' => 2,
                    'value' => 6
                ],
                [
                    'variety' => 11,
                    'grade' => 3,
                    'value' => 2
                ],

                [
                    'variety' => 12,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 12,
                    'grade' => 2,
                    'value' => 7
                ],
                [
                    'variety' => 12,
                    'grade' => 3,
                    'value' => 4
                ],

                [
                    'variety' => 13,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 13,
                    'grade' => 2,
                    'value' => 11
                ],
                [
                    'variety' => 13,
                    'grade' => 3,
                    'value' => 7
                ],

                [
                    'variety' => 14,
                    'grade' => 1,
                    'value' => 2
                ],
                [
                    'variety' => 14,
                    'grade' => 2,
                    'value' => 7
                ],
                [
                    'variety' => 14,
                    'grade' => 3,
                    'value' => 2
                ],

                [
                    'variety' => 15,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 15,
                    'grade' => 2,
                    'value' => 7
                ],
                [
                    'variety' => 15,
                    'grade' => 3,
                    'value' => 2
                ],

                [
                    'variety' => 16,
                    'grade' => 1,
                    'value' => 11
                ],
                [
                    'variety' => 16,
                    'grade' => 2,
                    'value' => 7
                ],
                [
                    'variety' => 16,
                    'grade' => 3,
                    'value' => 2
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
        Schema::dropIfExists('grades');
    }
}
