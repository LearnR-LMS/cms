<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Log;
use Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class BaseApiController extends Controller
{
    const STATUS_SUCCESS = true;
    const STATUS_FAILED = false;

    private $_statusCode = 200; // HTTP RESPONSE STATUS CODE, DEFAULT = 200
    private $_status;
    private $_code;
    private $_appCode;
    private $_message;
    private $_data;
    private $_errors = [];

    /**
     * @param $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        if(!empty($statusCode) && $statusCode > 599){
            $statusCode = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        $this->_statusCode = $statusCode;

        return $this;
    }

    /**
     * @param $code
     *
     * @return $this
     */
    protected function setCode($code)
    {
        if(!empty($code) && $code > 599){
            $code = \Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        $this->_code = $code;

        return $this;
    }

    /**
     * @param string|int $appCode
     *
     * @return $this
     */
    protected function setAppCode($appCode)
    {
        $this->_appCode = $appCode;

        return $this;
    }

    /**
     * @param $status
     *
     * @return $this
     */
    protected function setStatus($status)
    {
        $this->_status = $status;

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    protected function setMessage($message)
    {
        $this->_message = $message;

        return $this;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    protected function setData($data)
    {
        $this->_data = $data;

        return $this;
    }

    /**
     * @return Log
     */
    public function getLogger()
    {
        return Log::channel('api');
    }

    /***
     * End point return data
     *
     * @return JsonResponse
     */
    public function response()
    {
        // Prepare return data
        $data = [
            'success' => $this->_status,
            'status_code' => $this->_code,
            'app_code' => $this->_appCode,
            'message' => $this->_message,
            'data' => $this->_data,
            'errors' => $this->_errors,
        ];

        return Response::json($data, $this->_statusCode);
    }

    public function sendSuccessData($data = null, $message = null)
    {
        return $this->setStatus(self::STATUS_SUCCESS)
            ->setMessage($message)
            ->setCode(SymfonyResponse::HTTP_OK)
            ->setData($data)
            ->response();
    }

    public function sendErrorData($appCode = null, $code = null)
    {
        if ($appCode) {
            $this->setAppCode($appCode);
        }

        if ($code) {
            $this->setCode($code);
        }

        return $this->setStatus(self::STATUS_FAILED)
            ->response();
    }
}
