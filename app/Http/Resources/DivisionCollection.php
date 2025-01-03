<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DivisionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $perPage = $this->perPage();
        $nextPageUrl = $this->nextPageUrl() ? $this->nextPageUrl() . "&per_page=$perPage" : null; 
        $prevPageUrl = $this->previousPageUrl() ? $this->previousPageUrl() . "&per_page=$perPage" : null;
        return [
            'divisions' => $this->collection,
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'last_page_url' => $this->url($this->lastPage()) . "&per_page=$perPage",
                'next_page_url' => $nextPageUrl,
                'prev_page_url' => $prevPageUrl,
                'first_page_url' => $this->url(1) . "&per_page=$perPage",
                'per_page' => $perPage,
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
            ],
        ];
    }
}
