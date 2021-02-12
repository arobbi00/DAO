<?php
    require_once 'Contact.php';

    class ContactDAO {


        public function getConnection(){
            $mysqli = new mysqli("127.0.0.1", "cs2033user", "Spring-2021", "cs2033");
            if ($mysqli->connect_errno) {
                $mysqli=null;
            }
            return $mysqli;
        }

        public function getContacts(){
            $connection=$this->getConnection();
            $res = $connection->query("SELECT * from contacts;");
            while($row = $res->fetch_assoc()){
                $contact = new Contact();
                $contact->load($row);
                $contacts[]=$contact;
            }    
            $connection->close();
            return $contacts;
        }

        public function addContact($username, $email){
            $connection=$this->getConnection();
            $stmt = $connection->prepare("INSERT INTO contacts (username, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $stmt->close();
            $connection->close();
        }

        public function getAllContacts(){
            $connection=$this->getConnection();
            $stmt = $connection->prepare("SELECT * FROM contacts;"); 
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()){
                $contact = new Contact();
                $contact->load($row);
                $contacts[]=$contact;
            }    
            $stmt->close();
            $connection->close();
            return $contacts;
        }



    }
?>