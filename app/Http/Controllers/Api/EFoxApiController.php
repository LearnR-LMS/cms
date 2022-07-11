<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\EFox\UserStoreRequest;
use App\Http\Requests\EFox\UserUpdateRequest;
use App\Services\EFoxUserService;
use Exception;
use Illuminate\Http\Request;

class EFoxApiController extends BaseApiController
{
    protected $service;

    public function __construct(EFoxUserService $service)
    {
        $this->service = $service;
    }

    public function store(UserStoreRequest $request)
    {
        try {
            return $this->sendSuccessData(
                $this->service->store($request),
                "Thêm mới User thành công"
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
    public function update($id, UserUpdateRequest $request)
    {
        try {
            return $this->sendSuccessData(
                $this->service->update($id, $request),
                "Cập nhật User thành công"
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
    public function delete($id)
    {
        try {
            return $this->sendSuccessData(
                $this->service->delete($id),
                "Đã xóa User thành công"
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
}