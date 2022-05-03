<?php
    
    namespace App\Controllers;
    
    use Core\Controller;
    use App\Models\Category; 
    use App\Models\Comment; 
    use App\Models\User; 
    use App\Models\Product;  
    use App\Models\Cart; 

    class ProductController extends Controller 
    {
        private $category;
        private $comments;
        private $user;
        private $product;
        private $cart;

        public function __construct() 
        {
            $this->category = new Category();
            $this->comments = new Comment();
            $this->user = new User();
            $this->product = new Product();
            $this->cart = new Cart();
        }

        public function saveComment(int $id_Product)
        {
            if (empty($_POST)) {
                $payload = array( 
                    'message' => 'Fail: No data', 
                );
                
                exit(json_encode($payload));
            }

            if (empty($_POST['conditions'])) {
                $payload = array( 
                    'message' => 'Fail: No agreemnet on conditions', 
                );
                
                exit(json_encode($payload));
            }

            $this->comments->saveComment($id_Product, $_POST['full-name'], $_POST['email'], $_POST['comment']);
            
            // rerender the page, 302 redirect - prevent the form to be resumitted
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: ../detail/{$id_Product}");
            
            exit();
        }

        public function detail(int $id_Product)
        {
            $product    = $this->product->getSingleProduct($id_Product);
            $category   = $this->category->getSingleCategory($product['id_category']);
            $comments   = $this->comments->getProductComments($product['id']);
            $prev_Rated = $this->user->getUserRatingActivities();

            if (!$prev_Rated) {
                $prev_Rated = [];
            } 

            $this->render("product", [
                'title'      => 'Product Detail',
                'category'   => $category,
                'comments'   => $comments,
                'product'    => $product,
                'prev_rated' => $prev_Rated
            ]);
        }
    }

?>