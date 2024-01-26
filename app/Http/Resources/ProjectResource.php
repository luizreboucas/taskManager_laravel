<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TaskResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title' => $this->title,
            'creator' => $this->creator,
            'tasks'=> TaskResource::collection($this->whenLoaded('tasks')),
            'created_at'=> $this->created_id,
            'updated_at'=>$this->updated_at
        ];
    }
}
