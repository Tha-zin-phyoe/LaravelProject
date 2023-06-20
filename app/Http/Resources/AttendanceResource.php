<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            "id"=>$this->id,
            "employee_id"=>$this->employee->id,
            "employee"=>$this->employee->fullname,
            "datetime"=>$this->datetime,
            "status"=>$this->status,
            // 'error' => false,
            // 'message' => 'Admin Attendance Successfully',
            //  'data' => parent::toArray($request),
        ];
    }
}
