<?php
    require_once 'dbcontroller.php';

    function saveUsers($users){
        $db = new DbController();
        
        if($db->getState() == true){
            $conn = $db->getDb();
            $stmt = $conn->prepare("INSERT INTO users (title, messages, users) VALUES (:title, :messages, :users)");
            $stmt->bindParam(':title', $users['title']);
            $stmt->bindParam(':messages', $users['messages']);
            $stmt->bindParam(':users', $users['users']);
            $stmt->execute();
            return true;
        }else{
            return false;
        }

    }
?>