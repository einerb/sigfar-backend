<?php

namespace Core\Base;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;
class BaseEntity extends Model
{
    use RevisionableTrait;
        protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
