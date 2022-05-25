<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function animal()
    {
        return $this->hasOne(Animal::class, 'id', 'animal_id');
    }

    public function type()
    {
        return $this->hasOne(StatisticType::class, 'id', 'type_id');
    }
}
