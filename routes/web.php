<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/auctions/berry/{berryid}', 'AuctionController@showBerryAuctionPage')->name('berryAuctions');
Route::get('/auctions/variety/{varietyid}', 'AuctionController@showVarietyAuctionPage')->name('varietyAuctions');
Route::get('/auctions/{auctionid}', 'AuctionController@showAuctionPage')->name('showAuction');
Route::post('/placeBid/{auction}', 'AuctionController@placeBid')->name('placeBid');
Route::get('/account', 'AccountController@index')->name('account');
Route::post('/updateName', 'AccountController@updateName')->name('updateName');
Route::post('/updateDescription', 'AccountController@updateDescription')->name('updateDescription');
Route::post('/updateAvatar', 'AccountController@updateAvatar')->name('updateAvatar');
Route::get('/profile/{grower}',  'AccountController@showGrowerProfile')->name('showProfile');
Route::get('/dashboard', 'AuctionController@showMyAuctions')->name('auctions');
Route::get('/newauction', 'AuctionController@showNewAuctionForm')->name('newauction');
Route::post('/newauction', 'AuctionController@createNewAuction');
Route::get('/add-berry', "BerryController@showNewBerryForm")->name('newBerry');
Route::post('/add-berry', "BerryController@createNewBerry");

// These are for dynamic page updating
    // Interfaces for berry information - used on home page
Route::get('/get-current-berries', "BerryController@getBerriesWithAuctions");
Route::get('/get-current-berries-count', "BerryController@getNumberOfBerriesWithAuctions");
Route::get('/get-berry-image', "BerryController@getBerryImage");
    // Interfaces for variety information - used on berry info page
Route::get('/get-current-varieties', "BerryController@getVarietiesWithAuctions");
Route::get('/get-current-varieties-count', "BerryController@getNumberOfVarietiesWithAuctions");
Route::get('/get-variety-image', "BerryController@getVarietyImage");    
    // Interfaces for auction information - used on berry, variety and grower info pages
Route::get('/get-auctions-by-berry', "AuctionController@getAuctionsByBerry");
Route::get('/get-auction-count-by-berry', "AuctionController@getAuctionCountByBerry");
Route::get('/get-auctions-by-variety', "AuctionController@getAuctionsByVariety");
Route::get('/get-auction-count-by-variety', "AuctionController@getAuctionCountByVariety");
Route::get('/get-auctions-by-grower', "AuctionController@getAuctionsByGrower");
Route::get('/get-auction-count-by-grower', "AuctionController@getAuctionCountByGrower");
Route::get('/get-auction-image', "AuctionController@getAuctionImage");
    // Interfaces for grower information - used on the home page
Route::get('/get-growers', "AccountController@getGrowers");
Route::get('/get-grower-count', "AccountController@getGrowerCount");
Route::get('/get-grower-image', "AccountController@getImage");
    // Interfaces for utilities when adding a new auction
Route::get('/get-varieties', "BerryController@getAllVarieties"); // Used when creating a new auction. Loads list of varieties based on berry
Route::get('/get-price-calculation', "BerryController@getPriceEstimate");