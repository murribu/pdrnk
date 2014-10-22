<?php

namespace Pdrnk\OAuth2\Models;

class Podcast extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'podcasts';
  protected $primaryKey = 'po_key';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
?>