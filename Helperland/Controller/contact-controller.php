<?php 
    include("../Model/contact-model.php");
    include("./phpmailer/mail.php");

    class contactUs{
        public $data;
        public function __construct($data){
            $this->data = $data;
        }
        public function insertContact(){

            // file upload
            $fileName = $_FILES['attachment']['name'];
            $tempName = $_FILES['attachment']['tmp_name'];
            $filePath = "../View/attachment/".$fileName;
            if(!move_uploaded_file($tempName,$filePath)){
                header("location:../View/error.php?error=File Not Upload");
                exit();
            }

            // data insert in database
            $result="";
            $this->data['filename'] = $fileName;
            if(isset($_POST['submit'])){
                $insertObj = new insertContact($this->data);
                $result = $insertObj->insertContactDetails();
            }

            // php mail send
            // to activate mail system you have to give password in SMTP_PASS for email SMTP_EMAIL
            // you can change SMTP_ADMIN to send email to admin
            // all above change have to do in config file
            if($result){
                sendmail(Config::SMTP_ADMIN,$this->data['subject'],$this->data['msg'],$filePath);
                header("location:../View/contact.php");
            }
            else{
                header("location:../View/error.php?error=Data Not Inserted");
                exit();
            }
        }
    }
    
    $contact = new contactUs($_POST);
    $contact->insertContact();

?>