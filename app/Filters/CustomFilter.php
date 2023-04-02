<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomFilter implements Filter
{
    protected array $properties;

    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $firstProperty = array_shift($this->properties);
        $query->where($firstProperty, 'like', "%$value%");
        foreach ($this->properties as $property)
            $query->orWhere($property, 'like', "%$value%");
    }

}
