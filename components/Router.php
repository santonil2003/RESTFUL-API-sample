<?php

/**
 * router
 */
class Router
{

    private $_trim   = '/\^$';
    private $_routes = array();

    public function register($regex, $requstMethod, $callBack)
    {

        $route = new Route(trim($regex, $this->_trim), $requstMethod, $callBack);
        array_push($this->_routes, $route);
    }

    public function route()
    {
        $uri           = trim(Request::getValue($_REQUEST, 'uri'), $this->_trim);
        $requestMethod = Request::getValue($_SERVER, 'REQUEST_METHOD');
        $params        = array();

        foreach ($this->_routes as $route) {
            if (preg_match('#^' . $route->regex . '$#', $uri, $params) && ($requestMethod == $route->requestMethod)) {
                try {

                    if (count($params) >= 1) {
                        // trim first element of an arary
                        array_shift($params);
                    }

                    // call back
                    call_user_func_array($route->callBack, $params);
                } catch (Exception $exc) {
                    echo $exc->getMessage();
                }
            }

        }
    }

}
