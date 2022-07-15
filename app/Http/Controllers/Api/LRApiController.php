<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\LRService;
use Exception;
use Illuminate\Http\Request;

class LRApiController extends BaseApiController
{
    protected $service;

    public function __construct(LRService $service)
    {
        $this->service = $service;
    }

    public function usePen($address_wallet, $pen_id)
    {
        try {
            return $this->sendSuccessData(
                $this->service->usePen($address_wallet, $pen_id),
                "Thành công."
            );
        } catch (Exception $exception) {
            $this->getLogger()->error($exception);
            return $this->setMessage($exception->getMessage())->sendErrorData();
        }
    }
}