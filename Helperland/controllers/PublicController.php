<?php 
    include("phpmailer/mail.php");

    class PublicController{
        public $model;
        public $base_url = "http://localhost/psd-to-html/Helperland/";
        public $error_url = "http://localhost/psd-to-html/Helperland/?controller=Public&function=error";

        public function __construct(){
            include("models/Public.php");
            $this->model = new PublicModel();
        }

        public function home(){
            include("View/index.php");
        }

        public function price(){
            include("View/price.php");
        }

        public function contact(){
            include("View/contact.php");
        }

        public function about(){
            include("View/about.php");
        }

        public function faq(){
            include("View/faq.php");
        }

        public function error(){
            include("View/error.php");
        }

        public function sp_signup(){
            include('View/servicer_signup.php');
        }
    
        public function customer_signup(){
            include('View/customer_signup.php');
        }

        public function contact_us(){
            $result="";
            if(isset($_POST)){
                // file upload
                $filename = $_FILES['attachment']['name'];
                $tempName = $_FILES['attachment']['tmp_name'];
                $filePath = "View/attachment/".$filename;
                if($filename != null){
                    if(!move_uploaded_file($tempName,$filePath)){
                        header("location:".$this->error_url."&error=File Not Upload");
                        exit();
                    }
                }

                // data insert in database
                $_POST['filename'] = $filename;
                $result = $this->model->insertContactDetails($_POST);
                if($result){
                    // php mail send
                    // to activate mail system you have to give password in SMTP_PASS for email SMTP_EMAIL
                    // you can change SMTP_ADMIN to send email to admin
                    // all above change have to do in config file
                    sendmail(Config::SMTP_ADMIN,$_POST['subject'],$_POST['msg'],$filePath);
                    header("location:".$this->base_url."?controller=Public&function=contact");
                }
                else{
                    header("location:".$this->error_url."&error=Error Occured Try Again");
                    exit();
                }
            }
        }
    }

?>