<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePositions extends Model
{
    use HasFactory;

    /**
     * The publicly accessible constant containing the table used with the model.
     *
     * @var string
     */
    public const TABLE = 'employee_positions';
    /**
     * Timestamps present or not for the current model.
     *
     * @var boolean
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
    /**
     * The fillable fields of the model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeWherePosition(Builder $query, string $needle)
    {
        return $query->where('name', $needle)
            ->orWhere('slug', $needle);
    }
}
