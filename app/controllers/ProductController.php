<?php
    
    namespace App\Controllers;
    
    use Core\Controller;
    use App\Models\User; 
    use App\Models\Product;  
    use App\Models\Cart; 

    class ProductController extends Controller 
    {
        private $user;
        private $product;
        private $cart;

        public function __construct() 
        {
            $this->user = new User(); 
            $this->product = new Product(); 
            $this->cart = new Cart();  
        }

        public function detail(int $id_Product)
        {
            $prev_Rated = $this->user->getUserRatingActivities();

            if (!$prev_Rated) {
                $prev_Rated = [];
            } 

            $this->render("product", [
                'title'      => 'Product Detail',
                'product'    => $this->product->getSingleProduct($id_Product),
                'prev_rated' => $prev_Rated
            ]);
        }
    }

?>