<?php 
    include("../Model/contact-model.php");
    include("./phpmailer/mail.php");

    class contactUs{
        public $data;
        public function __construct($data){
            $this->data = $data;
        }
        public function insertContact(){
            $fileName = $_FILES['attachment']['name'];
            $tempName = $_FILES['attachment']['tmp_name'];
            $filePath = "../View/attachment/".$fileName;
            if(!move_uploaded_file($tempName,$filePath)){
                header("location:../View/error.php?error=File Not Upload");
            }

            $result="";
            $this->data['filename'] = $fileName;
            if(isset($_POST['submit'])){
                $insertObj = new insertContact($this->data);
                $result = $insertObj->insertContactDetails();
            }

            if($result){
                sendmail($this->data['email'],$this->data['subject'],$this->data['msg'],$filePath);
                header("location:../View/contact.php");
            }
            else{
                header("location:../View/error.php?error=Data Not Inserted");
            }
        }
    }
    
    $contact = new contactUs($_POST);
    $contact->insertContact();

?>