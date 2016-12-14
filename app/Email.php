<?php
namespace App;
use Eloquent;

class Email extends Eloquent {

	protected $fillable = [
							'to_address',
							'from_address',
							'subject',
							'body'
						];
	protected $primaryKey = 'id';
	protected $table = 'emails';
}
