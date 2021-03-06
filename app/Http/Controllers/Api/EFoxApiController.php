<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\EFox\CourseStoreRequest;
use App\Http\Requests\EFox\CourseUpdateRequest;
use App\Http\Requests\EFox\ScoreStoreRequest;
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
    
    //User
    public function store(UserStoreRequest $request)
    {
        try {
            return $this->sendSuccessData(
                $this->service->store($request),
                "Thêm mới User thành công."
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
                "Cập nhật User thành công."
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
                "Đã xóa User thành công."
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }

    //Courses
    public function getListCourse(Request $request)
    {
        try {
            return $this->sendSuccessData(
                $this->service->getListCourse($request),
                "Hiển thị danh sách thành công."
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
    public function storeCourse(CourseStoreRequest $request) {
        try {
            return $this->sendSuccessData(
                $this->service->storeCourse($request),
                "Thêm khóa học thành công."
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
    public function updateCourse($id, CourseUpdateRequest $request) {
        try {
            return $this->sendSuccessData(
                $this->service->updateCourse($id, $request),
                "Cập nhật khóa học thành công."
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
    public function deleteCourse($id) {
        try {
            return $this->sendSuccessData(
                $this->service->deleteCourse($id),
                "Xóa khóa học thành công."
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
    public function scoreCourse(ScoreStoreRequest $request) {
        try {
            return $this->sendSuccessData(
                $this->service->scoreCourse($request),
                "Lưu điểm số của khóa học thành công."
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
}