<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'=>$this->id,
            "team_employee"=>$this->employee,
            "team_id"=>$this->team->id,
          "teamName"=>$this->team->name,
            // 'error' => false,
            // 'message' => 'Admin Successfully',
            //  'data' => parent::toArray($request),
        ];
    }
}
