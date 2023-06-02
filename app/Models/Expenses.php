<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $expensesID
 * @property integer $categoryID
 * @property string $amount
 * @property string $entry_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 */
class Expenses extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'expenses';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'expensesID';

    /**
     * @var array
     */
    protected $fillable = ['name', 'categoryID', 'amount','entry_date','created_at', 'updated_at', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseCategory()
    {
        return $this->belongsTo('App\Models\ExpenseCategory', 'categoryID');
    }
}
