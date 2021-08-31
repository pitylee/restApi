<?php

namespace App\Models;

use App\Exceptions\EmployeeException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        $positionId = EmployeePositions::wherePosition($needle)->first()->id ?? null;

        if (!$positionId){
            throw new EmployeeException('Position can not be found for the given ID!');
        }

        return $query->where('position', $positionId);
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
        $managerId = $manager->first()->id ?? null;

        if (!$managerId){
            throw new EmployeeException('Manager can not be found for the given ID/Name!');
        }

        return $query->where('superior', $managerId);
    }
}
