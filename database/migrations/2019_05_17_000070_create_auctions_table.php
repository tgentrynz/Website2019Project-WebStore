<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grower');
            $table->unsignedBigInteger('variety');
            $table->string('title');
            $table->string('image');
            $table->longText('description');
            $table->longText('color_tags');
            $table->longText('taste_tags');
            $table->longText('uses_tags');
            $table->integer('amount');
            $table->unsignedBigInteger('grade');
            $table->dateTime('starting_time');
            $table->integer('length')->default(7);
            $table->decimal('starting_price', 12, 2);
            $table->foreign('grower')->references('id')->on('growers');
            $table->foreign('variety')->references('id')->on('varieties');
            $table->foreign('grade')->references('id')->on('grades');
            $table->timestamps();
        });
        DB::table('auctions')->insert(
            [
                [
                    'grower' => 1,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry1',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-21 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry2',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-21 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry3',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 5,
                    'title' => 'Raspberries for sale.',
                    'image' => 'raspberry1',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 6,
                    'title' => 'Raspberries for sale.',
                    'image' => 'raspberry2',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-21 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 7,
                    'title' => 'Raspberries 4 sale.',
                    'image' => 'raspberry3',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 3,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 8,
                    'title' => 'Raspberries 4 sale.',
                    'image' => 'raspberry1',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 2,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry1',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry2',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry3',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry1',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry2',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry3',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 5,
                    'title' => 'Raspberries for sale.',
                    'image' => 'raspberry1',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 6,
                    'title' => 'Raspberries for sale.',
                    'image' => 'raspberry2',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 7,
                    'title' => 'Raspberries 4 sale.',
                    'image' => 'raspberry3',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 3,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 8,
                    'title' => 'Raspberries 4 sale.',
                    'image' => 'raspberry2',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 2,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry2',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 1,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry3',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
                ],
                
                [
                    'grower' => 4,
                    'variety' => 1,
                    'title' => 'Berries for sale.',
                    'image' => 'strawberry1',
                    'description' => 'These berries are freshly picked from our orchard.',
                    'color_tags' => 'red',
                    'taste_tags' => 'sweet',
                    'uses_tags' => 'cooking, eating',
                    'amount' => 1,
                    'grade' => 1,
                    'starting_price' => 10.50,
                    'starting_time' => '2019-05-31 15:15:10',
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
        Schema::dropIfExists('auctions');
    }
}
