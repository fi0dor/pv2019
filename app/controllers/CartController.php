<?php
    
    namespace App\Controllers;
    
    use Core\Controller;
    use App\Models\User; 
    use App\Models\Cart; 
    use App\Models\Product;  

    class CartController extends Controller 
    {
        private $user;
        private $product;
        private $cart;
        private $promo_Codes = array(
            'BLACKFRIDAY22' => '-5',
            'BIGSALE'       => '-10%'
        );

        public function __construct() 
        {
            $this->user = new User(); 
            $this->product = new Product(); 
            $this->cart = new Cart(); 
        }

        public function index()
        { 
            $all_Cart_Records = $this->cart->getAllCartRecords();
            $count_Carts = $this->cart->countAllCarts();
            $cart_Products = [];

            if ($count_Carts > 0) {   
                foreach ($all_Cart_Records as $key => $value) {
                    $cart_Products[] = $this->product->getSingleProduct($key);
                } 
            }
            
            $all_Product_Records = $this->product->getAllProducts();
            $total_Cart_Cost = $this->computeCartCost($all_Cart_Records);
              
            $this->render("cart", [
                'title'             => 'My Shopping Cart',
                'all_cart_products' => $cart_Products, 
                'all_cart_quantity' => $all_Cart_Records,
                'cart_cost'         => $total_Cart_Cost
            ]);
        }

        public function updateCart(int $retType, int $product_Id, int $quantity)
        {   
            if ((int) $quantity < 1 || !is_numeric($quantity)) {
                $payload = array( 
                    'message' => 'Quantity must not be less than 1 and it must be an integer'
                );

                exit(json_encode($payload));
            }  
            
            $this->cart->updateCart($product_Id, $quantity);
            
            $payload = array( 
                'message'             => 'Success', 
                'new_Total_Count'     => $this->cart->countAllCarts(),
                'new_Unique_Count'    => $this->cart->countUniqueCartQty($product_Id),
                'new_Total_Cart_Cost' => $this->computeCartCost($this->cart->getAllCartRecords())
            );
            
            exit(json_encode($payload));
        }

        public function removeCart(int $retType, int $product_Id):array
        {
            $payload = array( 
                'message' => 'Failed'
            );

            if ($this->cart->removeCartItem($product_Id)) {
                $payload = array( 
                    'message'             => 'Success', 
                    'new_Total_Count'     => $this->cart->countAllCarts(),
                    'new_Unique_Count'    => $this->cart->countUniqueCartQty($product_Id),
                    'new_Total_Cart_Cost' => $this->computeCartCost($this->cart->getAllCartRecords())
                );
            }

            exit(json_encode($payload));
        }

        public function computeCartCost(array $cart_Records, string $promo_Code = null)
        {
            $total_Cost = 0;
            $i = 0;

            if (is_array($cart_Records) && count($cart_Records)) {
                foreach ($cart_Records as $key => $value) {
                    $total_Cost += (float) $this->product->getSingleProductPrice($key) * (int) $value;
                }
            }

            if (array_key_exists($promo_Code, $this->promo_Codes)) {
                if (strpos($this->promo_Codes[$promo_Code], '%') > 0) {
                    $total_Cost *= (100 + intval($this->promo_Codes[$promo_Code])) / 100;
                } else {
                    $total_Cost += intval($this->promo_Codes[$promo_Code]);
                }
            }
        
            return round((float) $total_Cost, 2);
        }   

        public function summary()
        {    
            $all_Cart_Records = $this->cart->getAllCartRecords();
            $count_Carts = $this->cart->countAllCarts();
            $cart_Products = [];

            if ($count_Carts > 0) {   
                foreach ($all_Cart_Records as $key => $value) {
                    $cart_Products[] = $this->product->getSingleProduct($key);
                } 
            }
            
            $applied_Promo_Code = array_key_first($this->promo_Codes);
            $applied_Promo_Value = $this->promo_Codes[$applied_Promo_Code];

            $all_Product_Records = $this->product->getAllProducts();
            $total_Cart_Cost = $this->computeCartCost($all_Cart_Records, $applied_Promo_Code);

            $this->render("summary", [
                'title'               => 'Cart Summary', 
                'all_cart_products'   => $cart_Products, 
                'all_cart_quantity'   => $all_Cart_Records,
                'applied_promo_code'  => $applied_Promo_Code,
                'applied_promo_value' => $applied_Promo_Value,
                'cart_cost'           => $total_Cart_Cost
            ]);
        }

        public function checkout(int $retType, int $product_Id, string $pick_up_type)
        {
            $all_Cart_Records = $this->cart->getAllCartRecords();
            $total_Cart_Cost = (gettype($all_Cart_Records) === 'array') ? $this->computeCartCost($all_Cart_Records) : 0;
             
            if ($this->cart->removeAllCarts()) {   
                $shipping_Cost = ($pick_up_type === 'UPS' ? UPS_SHIPPING_COST : PICK_UP_COST);
                $balance = $this->user->getUserWalletBalance() - ($total_Cart_Cost + $shipping_Cost);
                $newUserWalletBalance = $balance < 1 ? 0 : (float) $balance;
                
                $this->user->updateUserWalletBalance($newUserWalletBalance);
            }
            
            $this->render("checkout", [
                'title'             => 'Checkout',
                'thank_you_message' => '<i class="fa fa-check"></i> We just received your order. You\'ll hear from us shortly.<br/> Thank you once again.', 
                'cart_cost'         => $total_Cart_Cost
            ]);
        }
    }

?>