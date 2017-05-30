<?php

/**
 * router
 */
class Router {

    private $_trim = '/\^$';
    private $_routes = array();

    /**
     * register route
     * @param type $regex
     * @param type $requstMethod
     * @param type $callBack
     */
    public function register($regex, $requstMethod, $callBack) {
        $route = new Route(trim($regex, $this->_trim), $requstMethod, $callBack);
        array_push($this->_routes, $route);
    }

    /**
     * route based on uri and request method
     * @param type $uri
     * @param type $requestMethod
     */
    public function route($uri, $requestMethod) {
        $uri = trim($uri, $this->_trim);
        $params = array();

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