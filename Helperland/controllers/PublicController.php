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
            if(isset($_POST['submit'])){
                // file upload
                $filename = $_FILES['attachment']['name'];
                $tempName = $_FILES['attachment']['tmp_name'];
                $filePath = "View/attachment/".$filename;
                if(isset($_FILES["attachment"]) && !empty($filename)){
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
                    $name = ucwords($_POST["firstname"] . " " . $_POST["lastname"]);
                    $phone = $_POST["phone"];
                    $email = $_POST["email"];
                    $message = strtolower($_POST["msg"]);
                    $html = "
                            <h2><span style='border-bottom:1px solid black;'>Contact person Detailes<span></h2>
                            <p><b>Name</b> : $name</p>
                            <p><b>Mobile</b> : $phone</p>
                            <p><b>Email</b> : $email</p>
                            <p><b>Message</b> : $message</p>
                        ";
                    sendmail([Config::SMTP_ADMIN],$_POST['subject'],$html,$filePath);
                    header("location:".$this->base_url."?controller=Public&function=contact&parameter=success");
                }
                else{
                    header("location:".$this->error_url."&error=Error Occured Try Again");
                    exit();
                }
            }
        }
    }

?>