<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $roleID
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 */
class Roles extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'role';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'roleID';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'created_at', 'updated_at', 'status'];
}
