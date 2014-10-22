<?php

namespace Pdrnk\OAuth2\Models;

class Episode extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'episodes';
  protected $primaryKey = 'ep_key';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

}
