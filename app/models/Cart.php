<?php

    namespace App\Models;

    use Core\Model;
    use App\Models\User; 
    use App\Models\Cart; 
    use App\Models\Product; 

    class Cart extends Model 
    {   
        private $promo_Codes = array(
            'BLACKFRIDAY22'   => '-5',
            'BIGSALE'         => '-10 %',
            'SUPPORT2UKRAINE' => '+50 %'
        );

        public function getAllPromoCodes():array
        {   
            if (!is_array($this->promo_Codes) || empty($this->promo_Codes)) {
                return [];
            }

            return $this->promo_Codes;
        }

        public function getSinglePromoCode(string $promo_Code):string
        {   
            if (!is_array($this->promo_Codes) || empty($this->promo_Codes)) {
                return false;
            }

            if (!array_key_exists($promo_Code, $this->promo_Codes)) {
                return false;
            }

            return $this->promo_Codes[$promo_Code];
        }

        public function savePromoCode(string $promo_Code):bool
        {
            return $this->session->savePromoCode($promo_Code);
        }

        public function getPromoCode():mixed
        {
            return $this->session->getPromoCode();
        }

        public function removePromoCode():bool
        {
            return $this->session->removePromoCode();
        }

        public function checkCart(int $product_Id):bool
        {   
            return $this->session->checkCart($product_Id);
        }

        public function getAllCartRecords():array
        {
            if ($this->countUniqueCarts() > 0) {
                return $this->session->getAllCarts();
            } 
            
            return [];
        }

        public function saveCart(int $product_Id):bool
        {
            return $this->session->saveCart($product_Id);
        }

        public function updateCart(int $product_Id, int $quantity):bool
        { 
            return $this->session->updateCart($product_Id, $quantity);
        }

        public function removeCartItem(int $product_Id):bool
        {
            return $this->session->removeCartItem($product_Id);
        }

        public function removeAllCarts():bool
        {
            return $this->session->removeAllCarts();
        }
     
        public function countUniqueCarts():int
        {
            return $this->session->countUniqueCarts();
        }

        public function countAllCarts():int
        {
            return $this->session->countAllCarts();
        }

        public function countUniqueCartQty(int $product_Id):int
        {   
            return $this->session->countUniqueCartQty($product_Id);
        }
    }

?>