<?php

namespace App\Http\API\V1\Repositories\Language;

use App\Filters\CustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class LanguageRepository extends BaseRepository
{
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('code'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'code'])),

        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('code'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Language::class, $filters, $sorts);
    }

}
