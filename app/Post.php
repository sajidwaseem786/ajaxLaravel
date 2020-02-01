<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $fillale=[
   
        "title","body"

    ];

   protected function settitleAttribute($value){
       $this->attributes['title']=ucwords($value);
   }

   public function user(){


    return $this->belongsTo('\App\User');
}


}
