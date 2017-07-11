<?php

namespace LaravelTestTask;

use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'log';

    protected $fillable = ['from', 'to', 'name'];

    protected $dates = ['from', 'to', 'created_at', 'updated_at'];
}
