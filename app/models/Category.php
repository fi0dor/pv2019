<?php

    namespace App\Models;

    use Core\Model;
    use App\Models\Product; 

    class Category extends Model 
    {   
        protected $rows; 
        
        public function getAllCategories()
        {
            $this->db->runQuery("SELECT * FROM categories");
            
            if ($this->db->numRows() > 0) {
                while ($fetch = $this->db->getData()) {
                   $this->rows[] = $fetch;
                }
            }

            return $this->rows; 
        }

        public function getSingleCategory(int $id)
        {
            $this->db->runQuery("SELECT * FROM categories WHERE id = '$id'");
            
            if ($this->db->numRows() > 0) { 
                $row = $this->db->getData();
                
                return $row;
            }
            
            return false;
        }

        public function getAllProducts(int $category_Id)
        {
            $this->db->runQuery("SELECT * FROM products WHERE id_category = '$category_Id'");
            
            if ($this->db->numRows() > 0) {
                while ($fetch = $this->db->getData()) {
                   $this->rows[] = $fetch;
                }
            }

            return $this->rows; 
        }
    }

?>