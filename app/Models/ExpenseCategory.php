<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $categoryID
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 */
class ExpenseCategory extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ExpenseCategory';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'categoryID';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'created_at', 'updated_at', 'status'];
}
