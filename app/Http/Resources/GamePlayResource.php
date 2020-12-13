<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GamePlayResource extends JsonResource
{
    private $status;
    private $key;
    private $tries;

    public function __construct($status, $key, $tries)
    {
        parent::__construct([]);

        $this->status = $status;
        $this->key = $key;
        $this->tries = $tries;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'status' => $this->status,
            'key' => $this->key,
            'tries' => $this->tries,
            'session' => session('key', ''),
        ];
    }
}
