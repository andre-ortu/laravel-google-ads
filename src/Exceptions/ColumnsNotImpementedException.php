<?php

namespace AndreOrtu\LaravelGoogleAds\Exceptions;

use Exception;
use Throwable;

class ColumnsNotImpementedException extends Exception
{
    protected $message = "Please set variable columns in class";
}
