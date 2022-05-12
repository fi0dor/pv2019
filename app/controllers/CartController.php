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

        public function updatePromoCode(string $promo_Code)
        {
            $payload = array();

            $promo_Value = $this->cart->getSinglePromoCode($promo_Code);

            if (!empty($promo_Code) && empty($promo_Value)) {
                $payload = array( 
                    'message'    => 'Failed', 
                    'promo_Code' => $promo_Code
                );
            }

            if (!empty($promo_Code) && !empty($promo_Value) && $promo_Code !== $this->cart->getPromoCode()) {
                $payload = array( 
                    'message'             => 'Success', 
                    'html'                => $this->renderToString("promoCode", [
                                                'promo_code'  => $promo_Code,
                                                'promo_value' => $promo_Value
                                             ]),
                    'promo_Code'          => $promo_Code,
                    'new_Total_Cart_Cost' => $this->computeCartCost($this->cart->getAllCartRecords(), $promo_Value)
                );

                $this->cart->savePromoCode($promo_Code);
            }
            
            if (empty($promo_Code) && $this->cart->getPromoCode()) {
                $payload = array( 
                    'message'             => 'Removed',
                    'html'                => '',
                    'promo_Code'          => $this->cart->getPromoCode(),
                    'new_Total_Cart_Cost' => $this->computeCartCost($this->cart->getAllCartRecords(), null)
                );

                $this->cart->removePromoCode();
            }

            exit(json_encode($payload));
        }

        public function computeCartCost(array $cart_Records, string $promo_Value = null)
        {
            $total_Cost = 0;
            $i = 0;

            if (is_array($cart_Records) && count($cart_Records)) {
                foreach ($cart_Records as $key => $value) {
                    $total_Cost += (float) $this->product->getSingleProductPrice($key) * (int) $value;
                }
            }

            if (strpos($promo_Value, '%') > 0) {
                $total_Cost *= (100 + intval($promo_Value)) / 100;
            } else {
                $total_Cost += intval($promo_Value);
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
            
            $promo_Code = $this->cart->getPromoCode();
            $promo_Value = $this->cart->getSinglePromoCode($promo_Code);

            $all_Product_Records = $this->product->getAllProducts();
            $total_Cart_Cost = $this->computeCartCost($all_Cart_Records, $promo_Value);

            $this->render("summary", [
                'title'             => 'Cart Summary', 
                'all_cart_products' => $cart_Products, 
                'all_cart_quantity' => $all_Cart_Records,
                'promo_code'        => $promo_Code,
                'promo_value'       => $promo_Value,
                'cart_cost'         => $total_Cart_Cost
            ]);
        }

        public function checkout(int $retType, int $product_Id, string $pick_up_type)
        {
            $all_Cart_Records = $this->cart->getAllCartRecords();
            $total_Cart_Cost = (gettype($all_Cart_Records) === 'array') ? $this->computeCartCost($all_Cart_Records) : 0;
             
            if ($this->cart->removeAllCarts() && $this->cart->removePromoCode()) {   
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