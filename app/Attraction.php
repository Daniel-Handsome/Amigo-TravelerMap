<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    
    protected $fillable = [
        'name', 'website', 'tel', 'description', 'ticket_info', 'traffic_info', 'parking_info','user_id', 'position_id'
    ];
}
