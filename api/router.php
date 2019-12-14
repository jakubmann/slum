<?php
function classLoader($class)
{
   if (file_exists('./models/' . strtolower($class) . '.php')) {
        require('./models/' . strtolower($class) . '.php');
    }
}

spl_autoload_register('classLoader');

class Router {
        private static $instance = null;

        private function __clone() {
        }

        public function __wakeup() {
            throw new Exception('Serialization not supported.');
        }

        public static function getInstance() {
            if (!self::$instance) {
                self::$instance = new Router();
            }
            return self::$instance;
        }

        public function __construct() {
            $request = str_replace("/slum/api/", "", $_SERVER['REQUEST_URI']);
            $params = explode("/", $request);
            $this->route($params);
        }

        public function route($params) {
            $name = $params[0];
            if (isset($params[1])) {
                $method = $params[1];
                if (isset($params[2])) {
                    $arg = $params[2];
                }
            }

            if (class_exists($name)) {
                $model = new $name();
                if (isset($method)) {
                    if (method_exists($model, $method)) {
                        if (isset($arg)) {
                            $model->$method($arg);
                        } else {
                            $model->$method();
                        }
                    }
                }
            }
        }
}
