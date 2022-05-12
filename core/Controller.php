<?php

    namespace Core;  

    use App\Models\User; 
    use App\Models\Cart; 

    abstract class Controller
    {  
        public function render($filename, $data)
        { 
            $user = new User(); 
            $cart = new Cart();

            $data['count_carts'] = $cart->countAllCarts();
            $data['user_wallet_balance'] = $user->getUserWalletBalance();
            
            ob_start();
            
            if (file_exists(VIEW_ROOT . "{$filename}.php")) {
                require VIEW_ROOT . "{$filename}.php";
            } else {
                require VIEW_ROOT . 'home.php';
            }

            $main_Content = ob_get_clean(); 

            require_once VIEW_ROOT . 'templates/layout.php';
        }

        public function renderToString($filename, $data)
        { 
            if (file_exists(VIEW_ROOT . "{$filename}.php")) {
                ob_start();
                require VIEW_ROOT . "{$filename}.php";
                return ob_get_clean();
            }

            return false;
        }
    }

?>