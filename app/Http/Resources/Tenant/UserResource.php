<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Module;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $all_modules = Module::orderBy('description')->get();
        $modules_in_user = $this->modules->pluck('id')->toArray();
        $levels_in_user = $this->levels->pluck('id')->toArray();
        $modules = [];
        $levels = [];
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'number' => $this->number,
            'identity_document_type_id'=>"1",
            'api_token' => $this->api_token,
            'license' => $this->license,
            'establishment_id' => $this->establishment_id,
            'type' => $this->type,
            'modules' => $modules,
            'levels' => $levels,
            'locked' => (bool) $this->locked,
            'category' => $this->category,
            'is_arca' => (bool) $this->is_arca,
            'image_url' => $this->getImageUrl(),
        ];

    }

    /**
     * Devuelve la URL absoluta de la imagen del usuario, o null si no hay imagen.
     */
    private function getImageUrl()
    {
        if ($this->image && $this->image !== 'imagen-no-disponible.jpg') {
            return asset('storage/uploads/workers/' . $this->image);
        }
        return null;
    }
}