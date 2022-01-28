<?php
    include("../Model/connection.php");
    class insertContact extends Connection{
        public $data;

        public function __construct($data){
           $this->data = $data; 
        }
        
        public function insertContactDetails(){
            $name = $this->data['firstname']." ".$this->data['lastname'];
            $email = $this->data['email'];
            $phone = $this->data['phone'];
            $subject = $this->data['subject'];
            $msg = $this->data['msg'];
            $fileName = $this->data['filename'];
           
            $conn = $this->connect();

            $sql = "INSERT INTO contactus (Name,Email,Subject,PhoneNumber,Message,UploadFileName) VALUES ('$name','$email','$subject','$phone','$msg','$fileName')";
            $result = $conn->query($sql);

            $conn->close();

            return $result;
        }
    }
?>