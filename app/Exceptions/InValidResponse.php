<?php

namespace App\Exceptions;
class InValidResponse extends \Exception{
    
    protected $message = 'Unknown exception';
 // Exception message
    private $string;
 // Unknown
    protected $code = 0;
 // User-defined exception code
    protected $file;
 // Source filename of exception
    protected $line;
 // Source line of exception
    private $trace;
 // Unknown
    public function __construct($message = null, $code = 0)
    {
        if (! $message) {
            throw new $this('Unknown ' . get_class($this));
        }
        parent::__construct($message, $code);
    }
    
    
}