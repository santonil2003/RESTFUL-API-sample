<?php
/**
 * route
 */
class Route
{
    public $regex;
    public $requestMethod;
    public $callBack;

    public function __construct($regex, $requestMethod, $callBack)
    {
        $this->regex         = $regex;
        $this->requestMethod = $requestMethod;
        $this->callBack      = $callBack;
    }
}
