<?php

namespace Modules\College\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\College\Models\CollegeMember;

class CollegeParentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            $children = CollegeMember::where('parent_id', $row->id)->get();
            return [
                'id'          => $row->id,
                'parent' => $row->person,
                'children' => $children,

            ];
        });
    }
}
