<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GlobalResponse extends JsonResource
{
    //define properti
    public $status;
    public $statusCode;
    public $message;
    public $resource;
    public $error;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $resource, $statusCode)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    /**
     * toArray
     *
     * @param  mixed $request
     * @return array
     */
    public function toArray(Request $request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
