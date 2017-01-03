<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
							'id',
							'name',
							'description',
							'company_id',
                            'active'
						];
	protected $primaryKey = 'id';
	protected $table = 'locations';


	public function Company()
    {
        return $this->belongsTo('App\Company');
    }

    public function getCompanyName(){
        return $this->Company->name;
    }
}
