<?php
use App\Branch;
use App\Atm;
use App\Country;
use App\Parameter;
use App\Settings;
use Illuminate\Http\Request;
use App\Http\Requests;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//*****Cummulative starts here***********************************//
Route::get('cummulative', ['uses'=> 'CummulativeController@insertDailyData']);
Route::get('cummulative/make', ['uses'=> 'CummulativeController@makeCummulative']);
Route::get('cummulative/getdaily/{duration}', ['uses'=> 'CummulativeController@getCummulative']);
//*****Cummulative ends here***********************************//

