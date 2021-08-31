<?php

namespace App\Models;

use App\Models\EmployeePositions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class Employees extends Model
{
    use HasFactory;

    /**
     * The publicly accessible constant containing the table used with the model.
     *
     * @var string
     */
    public const TABLE = 'employees';

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
        'position',
        'superior',
        'startDate',
        'endDate',
    ];

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeWherePosition(Builder $query, string $needle)
    {
        return $query->where(
            'position',
            EmployeePositions::wherePosition($needle)->first()->id
        );
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeWhereManager(Builder $query, array $manager)
    {
        $manager = Employees::where(array_filter([
            $manager['id'] ? ['id', '=', intval($manager['id'])] : null,
            $manager['name'] ? ['name', '=', trim($manager['name'])] : null,
        ]))->wherePosition('management');

        return $query->where('superior', $manager->first()->id);
    }
}
