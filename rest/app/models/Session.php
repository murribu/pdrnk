<?php 

namespace Pdrnk\OAuth2\Models;

class Session extends Model
{
    /**
     * The database table
     *
     * @var string
     */
    protected $table = 'oauth_sessions';

    /**
     * Defining fillable attributes on the model
     *
     * @var array
     */
	protected $fillable = [
        'client_id',
        'owner_type',
        'owner_id',
	];

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
	public static $rules = [
        'client_id'  => '',
        'owner_type' => '',
        'owner_id'   => '',
	];

   /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            return $model->validate();
        });
    }
}