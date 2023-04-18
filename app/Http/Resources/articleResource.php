<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/** @mixin \App\Models\article */
class articleResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        $date = Carbon::parse($this->publishedAt)->format('d-m-Y H:i:s');
        return [
            'title' => $this->title,
            'author' => $this->author,
            'subTitle' => $this->subTitle,
            'article' => $this->article,
            'publishedAt' => $date,
        ];
    }
}
