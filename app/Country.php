<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
							'id',
							'name',
							'iso_name',
							'active'
						];
	protected $primaryKey = 'id';
	protected $table = 'countries';
}
