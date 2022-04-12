<?php

    namespace App\Models;

    use Core\Model;
    use App\Models\User; 
    use App\Models\Cart; 
    use App\Models\Product; 

    class Cart extends Model 
    {   
     
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