<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
							'id',
							'name',
							'description',
							'country_id',
                            'active'
						];
	protected $primaryKey = 'id';
	protected $table = 'companies';


	public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function getCountryName(){
        return $this->Country->name;
    }
}
