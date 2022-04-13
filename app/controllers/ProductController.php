<?php
    
    namespace App\Controllers;
    
    use Core\Controller;
    use App\Models\Category; 
    use App\Models\User; 
    use App\Models\Product;  
    use App\Models\Cart; 

    class ProductController extends Controller 
    {
        private $category;
        private $user;
        private $product;
        private $cart;

        public function __construct() 
        {
            $this->category = new Category();
            $this->user = new User();
            $this->product = new Product();
            $this->cart = new Cart();
        }

        public function detail(int $id_Product)
        {
            $product    = $this->product->getSingleProduct($id_Product);
            $category   = $this->category->getSingleCategory($product['id_category']);
            $prev_Rated = $this->user->getUserRatingActivities();

            if (!$prev_Rated) {
                $prev_Rated = [];
            } 

            $this->render("product", [
                'title'      => 'Product Detail',
                'category'   => $category,
                'product'    => $product,
                'prev_rated' => $prev_Rated
            ]);
        }
    }

?>