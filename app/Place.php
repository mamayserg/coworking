<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DateTime;

class Place extends Model
{
	protected $fillable = [
	   'id_city', 'address', 'start_time','end_time','number_of_seatplace'
	   ];

	public function isValid($place){
		$validatorPlace = Validator::make($place,  [
			'id_city' => 'required|max:255',
			'address' =>     'required|max:255',
			'start_time' => ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9]?)$^'],
			'end_time' => ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9]?)$^'],
			'number_of_seatplace' => 'required|max:255'
        ]);

		if ($validatorPlace->fails()){
            return false;
        }
		return true;
	}


    public function users(){
        return $this->belongsToMany('App\User', 'workers', 'place_id', 'user_id');
    }

    public function roles(){
        return $this->belongsToMany('App\Role', 'workers', 'place_id', 'role_id');
    }

    public function workers(){
        return $this->hasMany('App\Worker');
    }

    public function images(){
        return $this->hasMany('App\Image');
    }

	public function city(){
		return $this->belongsTo('App\City', 'id_city');
	}

	public function getCityName(){
		return $this->city->name;
	}

	public function spaces(){

        return $this->hasMany('App\NamePlace');
    }

	public function getPlaceName()
	{
		if ( $this->spaces->first()) {
			return $this->spaces->first()->name;
		}
		else {
				return 'Place does not exist';
		}
	}

}
