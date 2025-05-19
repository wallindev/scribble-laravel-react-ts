<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
  public function toArray($request) {
    return [
      'id'          => $this->id,
      'firstName'   => $this->firstname,
      'lastName'    => $this->lastname,
      'email'       => $this->email,
      // Include any other fields or relationships
    ];
  }
}
