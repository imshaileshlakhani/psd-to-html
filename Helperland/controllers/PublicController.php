<?php 
    include("phpmailer/mail.php");

    class PublicController{
        public $model;

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

        public function contact_us(){
            $base_url = "http://localhost/psd-to-html/Helperland/?controller=Public&function=contact";
            $error_url = "http://localhost/psd-to-html/Helperland/?controller=Public&function=error";

            if(isset($_POST)){
                $array = [
                    'name' => $_POST['firstname']." ".$_POST['lastname'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'subject' => $_POST['subject'],
                    'msg' => $_POST['msg'],
                    'fileName' => $_FILES['attachment']['name']
                ];
            }

            // file upload
            $tempName = $_FILES['attachment']['tmp_name'];
            $filePath = "View/attachment/".$array['fileName'];
            if(!move_uploaded_file($tempName,$filePath)){
                header("location:".$error_url."&error=File Not Upload");
                exit();
            }

            // data insert in database
            $result="";
            if(isset($_POST['submit'])){
                $result = $this->model->insertContactDetails($array);
            }

            // php mail send
            // to activate mail system you have to give password in SMTP_PASS for email SMTP_EMAIL
            // you can change SMTP_ADMIN to send email to admin
            // all above change have to do in config file
            if($result){
                sendmail(Config::SMTP_ADMIN,$array['subject'],$array['msg'],$filePath);
                header("location:".$base_url);
            }
            else{
                header("location:".$error_url."&error=Error Occured Try Again");
                echo "";
            }
        }
    }

?>