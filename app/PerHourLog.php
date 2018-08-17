<?php
/**
 * Created by Dada Tunde.
 *
 */
    namespace App;
    use Illuminate\Database\Eloquent\Model;
    use app\PerHourLog;

    class PerHourLog extends Model{
        protected $table='perhourlogs';

        protected $fillable = ['dispensing', 'outofservice', 'notdispensing'];
        public $timestamps = true;
        
    }