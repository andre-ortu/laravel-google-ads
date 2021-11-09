<?php

namespace AndreOrtu\LaravelGoogleAds\Exceptions;

use Exception;
use Throwable;

class DateNotImpementedException extends Exception
{
    protected $message = "Please set variable date in class";
}
