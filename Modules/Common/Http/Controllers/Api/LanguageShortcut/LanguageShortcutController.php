<?php

namespace Modules\Common\Http\Controllers\Api\LanguageShortcut;

use Modules\Common\Transformers\Api\LanguageShortcut\LanguageShortcutResource;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Repositories\IRepositories\LanguageShortcut\ILanguageShortcutRepository;

class LanguageShortcutController extends Controller
{

    public function __construct(private ILanguageShortcutRepository $languageShortcutRepository)
    {
    }

    public function index()
    {
        try {
            $languagesShortcuts = LanguageShortcutResource::collection($this->languageShortcutRepository->all());
            return $languagesShortcuts->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
