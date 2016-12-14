<?php
namespace App;
use Eloquent;

class Template extends Eloquent {

	protected $fillable = [
							'name',
							'category',
							'subject',
							'body'
						];
	protected $primaryKey = 'id';
	protected $table = 'templates';
}
