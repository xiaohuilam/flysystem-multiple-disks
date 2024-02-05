<?php

namespace Xiaohuilam\Flysystem\MultipleDisks;

use Illuminate\Http\Exceptions\HttpResponseException;

class MultipleDisksException extends HttpResponseException
{
    protected $errors = [];
    protected $disks = [];

    public function __construct($errors, $disks)
    {
        $this->errors = $errors;
        parent::__construct(response('Filesystem multi processing exception when disk=' . collect($disks)->implode(',')));
    }

    /**
     * Get errors
     *
     * @return Array<string,\Throwable>  {[diskName: string]: \Throwable}
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
