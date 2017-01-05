<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
							'id',
							'name',
							'description',
							'location_id',
                            'active'
						];
	protected $primaryKey = 'id';
	protected $table = 'departments';


	public function Location()
    {
        return $this->belongsTo('App\Location');
    }

    public function getLocationName(){
        return $this->Location->name;
    }
}
