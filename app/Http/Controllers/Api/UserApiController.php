<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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

    public function login(Request $request)
    {
        try {
            return $this->sendSuccessData(
                $this->service->login($request),
                "Đăng nhập thành công"
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
    public function refresh()
    {
        try {
            return $this->sendSuccessData(
                $this->service->refresh()
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
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