<?php
    
    class Router
    {
        public function routeParser($request)
        {
            $request->url = str_replace(APP_DIRECTORY, '', $request->url);

            $urlParts = array_slice(explode('/', trim($request->url)), 1);
            $urlCount = count($urlParts); 

            switch (true) {
                case $urlCount === 1:
                    $request->controller = ($urlParts[0] !== "") ? $urlParts[0] : "home";
                    $request->action     = 'index';
                    $request->params     = [];
                    break;

                case $urlCount === 2:
                    $request->controller = $urlParts[0];
                    $request->action     = ($urlParts[1] !== "") ? $urlParts[1] : "index";
                    $request->params     = []; 
                    break;
  
                case $urlCount >= 3:
                    $request->controller = $urlParts[0];
                    $request->action     = $urlParts[1];
                    $request->params     = array_slice($urlParts, 2);
                    break; 
  
                default:
                    exit('Invalid URL Path passed the router.php: ' . $request->url);
                    break;
            } 
        }
    }

?>