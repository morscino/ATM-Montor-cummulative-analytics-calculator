<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
        protected $table='dailylog';

        protected $fillable = ['dispensing', 'outofservice', 'notdispensing'];
        public $timestamps = true;
}
