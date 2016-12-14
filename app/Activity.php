<?php
namespace App;
use Eloquent;

class Activity extends Eloquent {

	protected $fillable = [
							'user_id',
							'module',
							'user_agent',
							'unique_id',
							'secondary_id',
							'activity',
							'ip'
						];
	protected $primaryKey = 'id';
	protected $table = 'activities';

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
