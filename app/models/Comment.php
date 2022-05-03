<?php

    namespace App\Models;

    use Core\Model;
    use App\Models\Product; 

    class Comment extends Model 
    {   
        protected $rows; 
        
        public function getAllComments()
        {
            $this->db->runQuery("SELECT * FROM comments WHERE status = 'active'");
            
            if ($this->db->numRows() > 0) {
                while ($fetch = $this->db->getData()) {
                   $this->rows[] = $fetch;
                }
            }

            return $this->rows; 
        }

        public function getSingleComment(int $id)
        {
            $this->db->runQuery("SELECT * FROM comments WHERE id = '$id' AND status = 'active'");
            
            if ($this->db->numRows() > 0) { 
                $row = $this->db->getData();
                return $row;
            }
            
            return false;
        }

        public function getProductComments(int $id_product)
        {
            $this->db->runQuery("SELECT * FROM comments WHERE id_product = '$id_product' AND status = 'active'");
            
            if ($this->db->numRows() > 0) {
                while ($fetch = $this->db->getData()) {
                   $this->rows[] = $fetch;
                }
            }

            return $this->rows; 
        } 

        public function saveComment(int $id_product, string $name, string $email, string $text)
        {
            $data = [
                'id_product' => $id_product,
                'name'       => $name,
                'email'      => $email,
                'text'       => $text
            ];

            if ($this->db->InsertData("comments", $data)) { 
                return true;
            }
            
            return false;
        } 
    }

?>