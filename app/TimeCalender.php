<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class TimeCalender extends Model
{
    protected $guarded = ['id'];

    public function failerMessage($ids , $model = null){
        return trans('api.models.'. str_replace('App\\' , '' , get_class($this)) );
    }

    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }

    public function bookedable()
    {
        return $this->morphTo();
    }

    public function canCreate($LastId = null ){
        return ! self::where('date' , parent::getAttribute('date'))
            ->where('freelancer_id' , parent::getAttribute('freelancer_id'))
            ->when($LastId != null , function ($query) use($LastId) {
                $query->where('id' , '!=',  $LastId);
            })
            ->where(function($query){
                $query->where(function ($query_start) {
                    $query_start->where('start_time' , '<' , parent::getAttribute('end_buffer'))
                        ->where('start_time' , '>=' , parent::getAttribute('start_time'));
                })->orWhere(function ($query_init) {
                    $query_init->where('start_time' , '<=' , parent::getAttribute('start_time'))
                        ->where('end_buffer' , '>=' , parent::getAttribute('end_buffer'));
                })->orWhere(function ($query_end) {
                    $query_end->where('end_buffer' , '>' , parent::getAttribute('start_time'))
                        ->where('end_buffer' , '<=' , parent::getAttribute('end_buffer'));
                });
            })->count() > 0 ;
    }
}
