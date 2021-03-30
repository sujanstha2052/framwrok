<?php

declare(strict_types=1);

namespace Sujanstha2052\Router;

use Sujanstha2052\Router\RouterInterface;

class Router implements RouterInterface
{
    protected array $routes = [];
    protected array $params = [];

    protected string $controllerSuffix = "controller";

    public function add(string $route, array $params = []): void
    {
        $this->routes[$route] = $params;
    }

    public function dispatch(string $url): void
    {
        if($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformUpperCamelCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);

            if(class_exists($controllerString)) {
                $controllerObject = new $controllerString();
                $action = $this->params('action');
                $action = $this->transformCamelCase($action);

                if(is_callable($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
        } else {
            throw new Exception();
        }
    }

    public function transformUpperCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public function transformCamelCase(string $string): string
    {
        return \lcfirst($this->transformUpperCamelCase($string));
    }

    private function match(): bool
    {
        foreach($this->routes as $route => $params) {
            if(preg_match($route, $url, $matches)) {
                foreach($matches as $key => $param) {
                    if(is_string($key)) {
                        $params[$key] = $param;
                    }
                }

                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function getNamespace(string $string): string
    {
        $namespace = "App\Controller\\";

        if(array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}