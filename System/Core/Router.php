<?php

namespace Core;

class Router
{
    /**
     * Request Object
     *
     * @var \Core\Request;
     */
    private $request = null;

    /**
     * Routes storage
     *
     * @var array
     */
    private $routes = [];

    /**
     * Router constructor
     *
     * @param \Core\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Add new routes
     *
     * @param array $routes
     * @throws \Exception
     * @return void
     */
    public function addRoutes($routes)
    {
        if (! is_array($routes)) {
            throw new \Exception('Routes should be an array');
        }
        foreach ($routes as $route) {
            call_user_func_array([$this, 'map'], $route);
        }
    }

    /**
     * Store the routes
     *
     * @param $route        A string contains the given prettyURL
     * @param $target       A string contains the given action
     * @param $method       A string contains the given method
     * @param $desc         A string contains the description of the url
     * @return void
     * @internal param A $name string contains a name of the given prettyURL
     */
    public function map($route, $target, $method, $desc)
    {
        $this->routes[] = [
            'prettyURL' => $route,
            'pattern' => $this->parseRoute($route),
            'action' => $this->getAction($target),
            'method' => strtoupper($method),
            'desc' => $desc,
        ];
    }

    /**
     * Generate a regex pattern for the given url
     *
     * @param $url
     * @return string
     */
    private function parseRoute($url)
    {
        $pattern = str_replace([':text', ':id'], ['([a-zA-Z0-9-ؤآئءإأ-ي]+)', '(\d+)'], $url);
        $pattern = '#^'.$pattern.'$#u';

        return $pattern;
    }

    /**
     * Get action
     *
     * @param $action
     * @return string
     */
    private function getAction($action)
    {
        $action = str_replace('/', '\\', $action);

        return strpos($action, '@') !== false ? $action : $action.'@index';
    }

    /**
     * Get route which fully matched
     *
     * @return array
     */
    public function dispatch()
    {
        //Loop through routes
        foreach ($this->routes as $route) {
            //if matched pattern and method
            if ($this->match($route['pattern'], $route['method'])) {

                //get name
                $desc = $route['desc'];

                //get args
                $arguments = $this->getArgumentsFrom($route['pattern']);

                //get method from route (ex: Admin/Categories@add = >
                //$controller = Admin/Categories
                //$method = add
                list($controller, $method) = explode('@', $route['action']);

                //return an array of $controller,$method,and $arguments values
                return ["controller" => $controller, "method" => $method, "args" => $arguments];
            }
        }

        return redirectTo('/404');
    }

    /**
     * Match $pattern and $method
     *
     * @param $pattern
     * @param $method
     * @return bool
     */
    private function match($pattern, $method)
    {
        return $this->MatchPatten($pattern) AND $this->MatchMethod($method);
    }

    /**
     * Match the requested prettyURL to the route’s prettyURL
     *
     * @param $pattern
     * @return bool
     */
    private function MatchPatten($pattern)
    {
        return preg_match($pattern, urldecode($this->request->getUrl()));
    }

    /**
     * Match the requested method to the route’s method
     *
     * @param $method
     * @return bool
     */
    private function MatchMethod($method)
    {
        return $method === $this->request->getMethod();
    }

    /**
     * Strip the requested prettyURL and get args
     *
     * @param $pattern
     * @return mixed
     */
    private function getArgumentsFrom($pattern)
    {
        preg_match($pattern, urldecode($this->request->getUrl()), $matches);
        array_shift($matches);

        return $matches;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}