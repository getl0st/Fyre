<?php
namespace Fyre\Core;

class Application {
    
    private $tokens;
    private $curent_url;
    private $parameters;
    private $handler_instance;
    private $request_method;
    private $curent_route;
    private $hooks;
    
    public function __construct() {
        
        $this->tokens = array(
                    ':string' => '([a-zA-Z]+)',
                    ':number' => '([0-9]+)',
                    ':alpha'  => '([^\/]+)',
                );
        $this->handler_instance = null;
        $this->request_method = strtolower($_SERVER['REQUEST_METHOD']); 
        $this->HandleURL();
    }
    
    public function serve($routes) {
        
        $discovered_route_controller = null;
        
        if (isset($routes[$this->curent_url])) {
    
                $discovered_route_controller = $routes[$this->curent_url][0];
                $this->curent_route = $routes[$this->curent_url];
                
        } elseif ($routes) {
    
            foreach ($routes as $pattern => $route_info) {

                $pattern = strtr($pattern, $this->tokens);
                if (preg_match('#^/?' . $pattern . '/?$#', $this->curent_url, $matches)) {

                    $discovered_route_controller = $route_info[0];
                    $this->parameters = $matches[1];
                    $this->curent_route = $route_info;
                    break;
                }
            }
        }
        if ($discovered_route_controller) {
            
            if (is_string($discovered_route_controller)) {
                
                $discovered_route_controller = strtolower($discovered_route_controller);
                $file = APP . "/controllers/" . $discovered_route_controller . ".controller.php";
                if (file_exists($file)) {
                    require_once($file);
                    $c = "\\Fyre\\Controller\\" . $discovered_route_controller;
                    $this->handler_instance = new $c();
                }
            } elseif (is_callable($discovered_route_controller)) {
                
                $c = "\\Fyre\\Controller\\" . $discovered_route_controller;
                $this->handler_instance = $c();
            }
        }
        
        $this->handle();
    }
    
    public function handle() {
        
        if ($this->handler_instance) {
            
            if (method_exists($this->handler_instance, $this->curent_route[1])) {
                
                if ($this->request_method == $this->curent_route[2]) {
                    
                    call_user_func_array(array($this->handler_instance, $this->curent_route[1]), array($this->parameters));
                } else {
                    
                    $this->fire('404');
                }
                    
            } else {

                $this->fire('404');
            }
        } else {
    
            $this->fire('404');
        }
    }
    
    private function HandleURL() {
        
        if (isset($_GET['url'])) {

            $url = trim($_GET['url'], '/');
            $url = "/" . filter_var($url, FILTER_SANITIZE_URL);
            $this->curent_url = $url;
        }
    }
    
    public function addHook($hook_name, $fn) {

        $this->hooks[$hook_name][] = $fn;
    }

    public function fire($hook_name, $params = null) {

        if (isset($this->hooks[$hook_name])) {

            foreach ($this->hooks[$hook_name] as $fn) {

                call_user_func_array($fn, array($params));
            }
        }
    }
}
