<?php
    include("models/connection.php");
    class PublicModel extends Connection{
        public function __construct(){
            $this->conn = $this->connect();
        }
        
        public function insertContactDetails($data){
            $name = $data['firstname'].' '.$data['lastname'];
            $email = $data['email'];
            $phone = $data['phone'];
            $subject = $data['subject'];
            $msg = $data['msg'];
            $fileName = $data['filename'];

            $sql = "INSERT INTO contactus (Name,Email,Subject,PhoneNumber,Message,UploadFileName) VALUES ('$name','$email','$subject','$phone','$msg','$fileName')";
            $result = $this->conn->query($sql);

            return $result;
        }
    }
?>