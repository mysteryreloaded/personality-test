<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Answer
 *
 * @property int $id
 * @property string $name
 * @property bool $selected
 * @property int $introvertScore
 */
class Answer extends Model
{
    protected $fillable = ['id', 'name', 'selected', 'introvertScore'];
}
