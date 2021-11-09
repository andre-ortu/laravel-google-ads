<?php

namespace AndreOrtu\LaravelGoogleAds\Exceptions;

use Exception;
use Throwable;

class ReportNameNotImpementedException extends Exception
{
    protected $message = "Please set variable report_name in class";
}
