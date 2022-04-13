<?php
    
    require "config/constants.php";
    require "core/Model.php";

    use Core\Model;

    class CategoryCreator extends Model 
    {
        private $output;

        public function createCategoryTable()
        {
            $query_create = "
                CREATE TABLE IF NOT EXISTS categories(
                    id INT(11) AUTO_INCREMENT,
                    name VARCHAR(255) NOT NULL,
                    caption VARCHAR(140) NOT NULL,
                    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
                    PRIMARY KEY(id)
                );

                ALTER TABLE products DROP COLUMN id_category;
                ALTER TABLE products ADD id_category INT NOT NULL AFTER id;
            ";

            if (!$this->db->runQueries($query_create)) {
                $this->output .= '<strong>ERROR:</strong> An error occured while creating the Category Table';
            } else {
                $this->output .= '<strong>SUCCESS:</strong> <strong> Category Table </strong> was <strong> successfully </strong> created'; 

                // Insert Dummy Data
                $dummyCategories = ['beverages' => 'Everything one can drink.', 'food' => 'Everything one can eat.'];
                $this->output .= '<p> --------------------- </p>';
                
                foreach ($dummyCategories as $name => $caption) {
                    $data = [
                        'name'    => $name,
                        'caption' => $caption
                    ];
                    
                    if (!$this->db->InsertData("categories", $data)) {
                        $this->output .= '<p><strong>An Error</strong> occured while inserting the <strong>' . ucfirst($name) . '</strong> record';
                    } else {
                        $this->output .= '<p><strong> ' . ucfirst($name) . ' record </strong> was <strong> successfully </strong> inserted </p>';
                    }
                }  

                $query_update_products = "
                    UPDATE products SET id_category = (SELECT id FROM categories WHERE name = 'food' LIMIT 1) WHERE name LIKE '%apple%' OR name LIKE '%cheese%';
                    UPDATE products SET id_category = (SELECT id FROM categories WHERE name = 'beverages' LIMIT 1) WHERE name LIKE '%beer%' OR name LIKE '%water%';
                ";

                if (!$this->db->runQueries($query_update_products)) {
                    $this->output .= '<strong>ERROR:</strong> An error occured while updating the Product Table with categories assignment';
                } else {
                    $this->output .= '<strong>SUCCESS:</strong> <strong> Product Table </strong> was <strong> successfully </strong> updated with the categories'; 
                }
            }
            
            return $this->output;
        }
    }

    $categories_Creator = new CategoryCreator();
    
    echo $categories_Creator->createCategoryTable(); 

?>