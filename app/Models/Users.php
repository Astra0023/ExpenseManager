<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $userID
 * @property string $name
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property string $roleID
 * @property string $status
 */
class Users extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'userID';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'roleID', 'created_at', 'updated_at', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'roleID');
    }
}
