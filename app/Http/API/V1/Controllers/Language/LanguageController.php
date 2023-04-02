<?php

namespace App\Http\API\V1\Controllers\Language;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Language\LanguageRepository;
use App\Http\API\V1\Requests\Language\StoreLanguageRequest;
use App\Http\API\V1\Requests\Language\UpdateLanguageRequest;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Language;
use Illuminate\Http\JsonResponse;

/**
 * @group Languages
 * APIs for language settings
 */
class LanguageController extends Controller
{
    protected LanguageRepository $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->languageRepository = $languageRepository;
        $this->authorizeResource(Language::class);
    }

    /**
     * Show all languages
     *
     * This endpoint lets you show all languages
     *
     * @responseFile storage/responses/admin/languages/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam filter[code] string Field to filter items by code.
     * @queryParam sort string Field to sort items by id,name, code.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->languageRepository->index();

        return $this->showAll($paginatedData->getData(), LanguageResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific language
     *
     * This endpoint lets you show specific language
     *
     * @responseFile storage/responses/admin/languages/show.json
     *
     * @param Language $language
     * @return JsonResponse
     */
    public function show(Language $language): JsonResponse
    {
        return $this->showOne($this->languageRepository->show($language), LanguageResource::class);
    }

    /**
     * Add language
     *
     * This endpoint lets you add language
     *
     * @responseFile storage/responses/admin/languages/store.json
     *
     * @param StoreLanguageRequest $request
     * @return JsonResponse
     */
    public function store(StoreLanguageRequest $request): JsonResponse
    {
        $language = $this->languageRepository->store($request->validated());

        return $this->showOne($language, LanguageResource::class, __('The language added successfully'));
    }

    /**
     * Update specific language
     *
     * This endpoint lets you update specific language
     *
     * @responseFile storage/responses/admin/language/update.json
     *
     * @param UpdateLanguageRequest $request
     * @param Language $language
     * @return JsonResponse
     */
    public function update(UpdateLanguageRequest $request, Language $language): JsonResponse
    {
        $languageUpdate = $this->languageRepository->update($language, $request->validated());

        return $this->showOne($languageUpdate, LanguageResource::class, __("Language's information updated successfully"));
    }

    /**
     * Delete specific language
     *
     * This endpoint lets you delete specific language
     *
     * @responseFile storage/responses/admin/languages/delete.json
     *
     * @param Language $language
     * @return JsonResponse
     */
    public function destroy(Language $language): JsonResponse
    {
        $this->languageRepository->delete($language);

        return $this->responseMessage(__('Language deleted successfully'));
    }
}
