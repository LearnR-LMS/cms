<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\UserStoreRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserApiController extends BaseApiController
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        try {
            return $this->sendSuccessData(
                $this->service->store($request)
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
}
