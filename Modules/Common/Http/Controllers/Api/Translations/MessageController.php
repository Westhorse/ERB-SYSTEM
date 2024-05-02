<?php

namespace Modules\Common\Http\Controllers\Api\Translations;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Entities\Api\Translations\Message;
use Modules\Common\Http\Requests\Api\Translations\MessageRequest;
use Modules\Common\Repositories\IRepositories\Translations\IMessageRepository;
use Modules\Common\Transformers\Api\Translations\CaptionsObjectResource;
use Modules\Common\Transformers\Api\Translations\MessageResource;


class MessageController extends Controller
{

    public function __construct(private IMessageRepository $messageRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function index()
    {
        try {
            $messages = MessageResource::collection($this->messageRepository->all());
            return $messages->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function getAllObjects()
    {
        try {
            $captions = CaptionsObjectResource::collection($this->messageRepository->getAllObjects());
            return $captions;
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function store(MessageRequest $request)
    {
        try {
            $model = $this->messageRepository->create($request->validated());
            $message = new MessageResource($model);
            return $message->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Message $message
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(Message $message, MessageRequest $request)
    {
        try {
            $this->messageRepository->update($request->validated(), $message['id']);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
