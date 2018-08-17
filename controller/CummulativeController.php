<?php
/*

@Author:   Morscino
@Date:     30 oct, 2017...

*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\FetchDataController;
use App\PerHourLog;
use App\DailyLog;
use DB;

class CummulativeController extends Controller
{
    //
    public function insertDailyData(){

     $data = new FetchDataController;
     $allCummulative = $data->cummulativeData();

     $perDispensing = round($allCummulative[0],2);
     $perOutOfService = round($allCummulative[1],2);
     $perNotDispensing = round($allCummulative[2],2);

     $date = date("l jS F Y h:i A");

     //insert data into database...

     $perHourLogs = new PerHourLog;

     $perHourLogs->dispensing = $perDispensing;
     $perHourLogs->outofservice = $perOutOfService;
     $perHourLogs->notdispensing = $perNotDispensing;

     $perHourLogs->save();

    
    }

    public function makeCummulative(){
        //get data from Per Hour table...
        //perform calculations...
        //insert new data into per day table...

        $cummulatives = PerHourLog::all();
        $totalNum = PerHourLog::all()->count();

        if(count($cummulatives)){
            $x = $a= $c = 0;
            foreach ($cummulatives as $cummulative) {
                 $dispensing = $cummulative->dispensing;
                 $outofservice = $cummulative->outofservice;
                 $notdispensing = $cummulative->notdispensing;

                     $y = $x + $dispensing;//Adds all dispensing
                     $x = $y;

                     $b = $a + $outofservice;//Adds all out of service
                     $a = $b;

                     $d = $c + $notdispensing;//Adds all dispensing
                     $c = $d;
                 
            }

            $allDispensing = $x;
            $cummDispensing = $allDispensing/$totalNum;

            $alloutOfService = $a;
            $cummoutOfService = $alloutOfService/$totalNum;

            $allnotDispensing = $c;
            $cummnotDispensing = $allnotDispensing/$totalNum;

            $DailyLog = new DailyLog;

            $DailyLog->dispensing = $cummDispensing;
            $DailyLog->outofservice = $cummoutOfService;
            $DailyLog->notdispensing = $cummnotDispensing;

            $DailyLog->save();

            //Delete all data from the per hour table..
            PerHourLog::getQuery()->delete();

        }

    }


    public function getCummulative($duration){
            //Gets Cummulative for the last 24hrs,48hrs and 72hrs

            $dailyLogs = DailyLog::orderBy('id','desc')
                                ->take(3)
                                ->get();

            $hrs24data = $dailyLogs[0];
            $hrs48data = $dailyLogs[1];
            $hrs72data = $dailyLogs[2];
            
            if($duration == 'firstday'){
                $cummDispensing = $hrs24data->dispensing;
                $cummOutOfService = $hrs24data->outofservice;
                $cummNotDispensing = $hrs24data->notdispensing;
            }
            elseif($duration == 'secondday') {
                $cummDispensing = $hrs48data->dispensing;
                $cummOutOfService = $hrs48data->outofservice;
                $cummNotDispensing = $hrs48data->notdispensing;
            } 
            elseif($duration == 'thirdday') {
                $cummDispensing = $hrs72data->dispensing;
                $cummOutOfService = $hrs72data->outofservice;
                $cummNotDispensing = $hrs72data->notdispensing;
            } 

            $cummulativeAll = array('cummDispensing'=>$cummDispensing,'cummOutOfService'=>$cummOutOfService,'cummNotDispensing'=>$cummNotDispensing); 
            
            return  $cummulativeAll;                
                            
    }



}
