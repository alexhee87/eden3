<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
							'id',
							'name',
							'description',
							'department_id',
                            'active'
						];
	protected $primaryKey = 'id';
	protected $table = 'teams';


	public function Department()
    {
        return $this->belongsTo('App\Department');
    }

    public function getDepartmentName(){
        return $this->Department->name;
    }
}
