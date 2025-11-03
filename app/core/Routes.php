<?php

class Routes {
    private $routes = [];

    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($method, $uri) {
        // Hapus query string
        $uri = strtok($uri, '?');
        
        foreach ($this->routes as $route) {
            // Ubah pattern route menjadi regex
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([0-9]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';
            
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                // Hapus match penuh dari array
                array_shift($matches);
                
                require_once __DIR__ . '/../Controllers/' . $route['controller'] . '.php';
                
                $controller = new $route['controller']();
                call_user_func_array([$controller, $route['action']], $matches);
                return;
            }
        }
        
        // Route tidak ditemukan
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}

// Definisi semua routes
$router = new Routes();

// Login routes
$router->add('GET', '/login', 'LoginController', 'index');
$router->add('POST', '/login/authenticate', 'LoginController', 'authenticate');
$router->add('GET', '/logout', 'LoginController', 'logout');

// Dashboard
$router->add('GET', '/dashboard', 'DashboardController', 'index');

// Pegawai routes
$router->add('GET', '/pegawai', 'PegawaiController', 'index');
$router->add('POST', '/pegawai/create', 'PegawaiController', 'create');
$router->add('POST', '/pegawai/update/{id}', 'PegawaiController', 'update');
$router->add('POST', '/pegawai/delete/{id}', 'PegawaiController', 'delete');
$router->add('GET', '/pegawai/json', 'PegawaiController', 'getJson');
$router->add('GET', '/pegawai/json/{id}', 'PegawaiController', 'getJson');

// Jabatan routes
$router->add('POST', '/jabatan/create', 'JabatanController', 'create');
$router->add('POST', '/jabatan/update/{id}', 'JabatanController', 'update');
$router->add('POST', '/jabatan/delete/{id}', 'JabatanController', 'delete');
$router->add('GET', '/jabatan/json', 'JabatanController', 'getJson');
$router->add('GET', '/jabatan/json/{id}', 'JabatanController', 'getJson');

return $router;
?>