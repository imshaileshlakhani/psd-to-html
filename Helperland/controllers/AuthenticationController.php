<?php
include("phpmailer/mail.php");

class AuthenticationController{
    public $model;
    public $error_url = "http://localhost/psd-to-html/Helperland/?controller=Public&function=error";
    public $base_url = "http://localhost/psd-to-html/Helperland/";

    public function __construct(){
        include("models/Authentication.php");
        $this->model = new Authentication();
    }

    public function login(){
        if(isset($_POST["signin"])){
            $userdata = $this->model->validate($_POST);
            if(count($userdata)>0){
                $_SESSION['userdata'] = $userdata;
                if(isset($_POST['remember'])){
                    setcookie('email',$_POST["username"],time()+3600);
                    setcookie('psw',$_POST["password"],time()+3600);
                }
                else{
                    setcookie('email','',time());
                    setcookie('psw','',time());
                }
                header("Location:".$this->base_url."?controller=Public&function=home");
            }else{
                header("location:".$this->error_url."&error=Username or password is incorrect!!!");
            }
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        header("location:".$this->base_url."?controller=Public&function=home");
    }

    public function user_signup(){
        $result = "";
        if(isset($_POST['register'])){
            $result = $this->model->is_present($_POST);
            if(!$result){
                $result = $this->model->insert($_POST);
                if($result){
                    header("Location:".$this->base_url."?controller=Public&function=home");
                }else{
                    header("location:".$this->error_url."&error=Unable to signup!!!");
                }
            }
            else{
                header("location:".$this->error_url."&error=Email and Mobile is already register");
            }
        }
    }

    public function forgot_password_link(){
        if(isset($_POST['send'])){
            $result = $this->model->validate($_POST);
            if(count($result) > 0){
                $link = $this->base_url."?controller=Authentication&function=forgot_password&parameter=".$_POST['email'];
                $msg = "<h2><a href='$link' style='color:red' >Click here to change your password</a></h2>";
                $subject = "Forgot Password";
                sendmail([$_POST['email']],$subject,$msg);
                header("Location:".$this->base_url."?controller=Public&function=home");
            }else{
                header("location:".$this->error_url."&error=Envalid email!!!");
            }
        }
    }

    public function forgot_password(){
        if(isset($_POST['save'])){
            $result = $this->model->change_password($_POST);
            if($result){
                header("Location:".$this->base_url."?controller=Public&function=home");
            }
            else{
                header("location:".$this->error_url."&error=Not able to change password");
            }
        }
        include('View/forgot_password.php');
    }
}

?>