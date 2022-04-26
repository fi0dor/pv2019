<?php
    
    require "config/constants.php";
    require "core/Model.php";

    use Core\Model;

    class CommentsCreator extends Model 
    {
        private $output;

        public function createCommentsTable()
        {
            $query_create = "
                CREATE TABLE IF NOT EXISTS comments(
                    id INT(11) AUTO_INCREMENT,
                    id_product INT(11) NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NULL,
                    text TEXT NOT NULL,
                    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
                    PRIMARY KEY(id)
                );
            ";

            if (!$this->db->runQueries($query_create)) {
                $this->output .= '<strong>ERROR:</strong> An error occured while creating the Comments Table';
            } else {
                $this->output .= '<strong>SUCCESS:</strong> <strong> Comments Table </strong> was <strong> successfully </strong> created'; 

                // Insert Dummy Data
                $dummyComments = [
                    1 => array('name' => 'John Smith',     'email' => 'john.smith@gmail.com', 'text' => 'Comment 1'),
                    2 => array('name' => 'Elton Howitzer', 'email' => 'elto@office.com',      'text' => 'Comment 2'),
                    3 => array('name' => 'Jabal Ah Madal', 'email' => '',                     'text' => 'Comment 3'),
                    4 => array('name' => 'Petr van Brem',  'email' => '',                     'text' => 'Hackie comment. <a href="javascript\x3Ajavascript:alert(1)" id="fuzzelement1">test</a>')
                ];

                $this->output .= '<p> --------------------- </p>';
                
                foreach ($dummyComments as $id_product => $comment) {
                    $data = [
                        'id_product' => $id_product,
                        'name'       => $comment['name'],
                        'email'      => $comment['email'],
                        'text'       => $comment['text']
                    ];
                    
                    if (!$this->db->InsertData("comments", $data)) {
                        $this->output .= '<p><strong>An Error</strong> occured while inserting the <strong>' . $id_comment . '</strong> record';
                    } else {
                        $this->output .= '<p><strong> ' . $id_comment . ' record </strong> was <strong> successfully </strong> inserted </p>';
                    }
                }  
            }
            
            return $this->output;
        }
    }

    $comments_Creator = new CommentsCreator();
    
    echo $comments_Creator->createcommentsTable(); 

?>