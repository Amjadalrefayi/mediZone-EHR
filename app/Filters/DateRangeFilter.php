<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DateRangeFilter implements Filter
{
    protected string $column;

    public function __construct(string $column)
    {
        $this->column = $column;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value[0]);
        $endDate = Carbon::createFromFormat('Y-m-d', $value[1]);

        return $query->whereDate($this->column, '>=', $date)->whereDate($this->column, '<=', $endDate);
    }
}
