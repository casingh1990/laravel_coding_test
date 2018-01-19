<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\CreatedPrescriber;

class Prescriber extends Model
{
    public function save(array $options = Array()){
        event(new CreatedPrescriber($this));
        parent::save($options);
    }
}
