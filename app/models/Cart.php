<?php

    namespace App\Models;

    use Core\Model;
    use App\Models\User; 
    use App\Models\Cart; 
    use App\Models\Product; 

    class Cart extends Model 
    {   
        public function getAllShippingTypes():array
        {   
            if (!is_array(SHIPPING_TYPES) || empty(SHIPPING_TYPES)) {
                return [];
            }

            return SHIPPING_TYPES;
        }

        public function getSingleShippingType(string $shipping_Type):mixed
        {   
            if (!is_array(SHIPPING_TYPES) || empty(SHIPPING_TYPES)) {
                return false;
            }

            if (!array_key_exists($shipping_Type, SHIPPING_TYPES)) {
                return false;
            }

            return array_merge(array("key" => $shipping_Type), SHIPPING_TYPES[$shipping_Type]);
        }

        public function saveShippingType(string $shipping_Type):bool
        {
            return $this->session->saveShippingType($shipping_Type);
        }

        public function getShippingType():mixed
        {
            return $this->session->getShippingType();
        }

        public function removeShippingType():bool
        {
            return $this->session->removeShippingType();
        }

        public function getAllPromoCodes():array
        {   
            if (!is_array(PROMO_CODES) || empty(PROMO_CODES)) {
                return [];
            }

            return $this->promo_Codes;
        }

        public function getSinglePromoCode(string $promo_Code):mixed
        {   
            if (!is_array(PROMO_CODES) || empty(PROMO_CODES)) {
                return false;
            }

            if (!array_key_exists($promo_Code, PROMO_CODES)) {
                return false;
            }

            return array_merge(array("key" => $promo_Code), PROMO_CODES[$promo_Code]);
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