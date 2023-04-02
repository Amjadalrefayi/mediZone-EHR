<?php

namespace App\Http\API\V1\Repositories\User;

use App\Filters\CustomFilter;
use App\Filters\DateRangeFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\User;
use App\Models\UserLanguages;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('marital_status'),
            AllowedFilter::exact('gender'),
            AllowedFilter::exact('deceased'),
            AllowedFilter::exact('type'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'family', 'suffix', 'prefix'])),
            AllowedFilter::custom('birth_date', new DateRangeFilter('birth_date')),
            AllowedFilter::custom('deceased_date', new DateRangeFilter('deceased_date')),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('family'),
            AllowedSort::field('suffix'),
            AllowedSort::field('prefix'),
            AllowedSort::field('birth_date'),
            AllowedSort::field('deceased_date'),
            AllowedSort::field('created_at'),
        ];

        return $this->filter(User::class, $filters, $sorts);
    }

    public function indexRoles(User $user): PaginatedData
    {

        $filters = [
            AllowedFilter::partial('name'),
            AllowedFilter::partial('description'),
            AllowedFilter::partial('id'),
        ];

        $sorts = [
            AllowedSort::field('name'),
            AllowedSort::field('description'),
            AllowedSort::field('id'),
        ];

        return $this->filter($user->roles(), $filters, $sorts);
    }

    public function editRoles($data, User $user): void
    {
        $user->roles()->sync($data);
    }

    public function storeUserLanguage(Collection $data)
    {
        UserLanguages::create([
            'user_id' => $data->get('user_id'),
            'language_id' => $data->get('language_id'),
            'preferred' => $data->get('preferred'),
        ]);

    }

}
