<?php

namespace App\Http\API\V1\Repositories\Organization;

use App\Filters\CustomFilter;
use App\Filters\DateRangeFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Organization;
use App\Models\UserLanguages;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class OrganizationRepository extends BaseRepository
{
    public function __construct(Organization $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),

            AllowedFilter::partial('name'),
            AllowedFilter::partial('description'),
            AllowedFilter::exact('active'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'description'])),

        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('description'),
            AllowedSort::field('active'),
            AllowedSort::field('created_at'),
        ];


        return $this->filter(Organization::class, $filters, $sorts);
    }
    public function storeOrganizationTypes(Collection $data)
    {
        UserLanguages::create([
            'organization_id' => $data->get('organization_id'),
            'code_id' => $data->get('code_id'),
            'description' => $data->get('description'),
        ]);

    }

}
