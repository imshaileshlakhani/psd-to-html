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
        if(isset($_POST)){
            $userdata = $this->model->validate($_POST);
            if(count($userdata)>0){
                if($userdata['UserTypeId'] == 2 && $userdata['IsApproved'] != 1){
                    echo json_encode(['status'=>false,'approved'=>0,'error'=>'You are not approved by Admin']);
                    exit();
                }
                $_SESSION['userdata'] = $userdata;
                if($_POST['remember']){
                    setcookie('email',$_POST["username"],time()+3600);
                    setcookie('psw',$_POST["password"],time()+3600);
                }
                else{
                    setcookie('email','',time());
                    setcookie('psw','',time());
                }
                echo json_encode(['status'=>true,'UserTypeId'=>$userdata['UserTypeId']]);
            }else{
                echo json_encode(['status'=>false,'approved'=>1,'error'=>'Username or password is incorrect!']);
            }
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        echo json_encode(['status'=>true]);
    }

    public function user_signup(){
        $result = "";
        if(isset($_POST)){
            $result = $this->model->is_present($_POST);
            if(!$result){
                $result = $this->model->insert($_POST);
                if($result){
                    echo json_encode(['status'=>true]);
                }else{
                    echo json_encode(['status'=>false,'error'=>'Unable to signup!']);
                }
            }
            else{
                echo json_encode(['status'=>false,'error'=>'Email and Mobile is already register']);
            }
        }
    }

    public function forgot_password_link(){
        if(isset($_POST)){
            $result = $this->model->validate($_POST);
            if(count($result) > 0){
                $link = $this->base_url."?controller=Authentication&function=forgot_password&parameter=".$_POST['email'];
                $msg = "<h2><a href='$link' style='color:red' >Click here to change your password</a></h2>";
                $subject = "Forgot Password";
                sendmail([$_POST['email']],$subject,$msg);
                echo json_encode(['status'=>true]);
            }else{
                echo json_encode(['status'=>false,'error'=>'Invalid email!']);
            }
        }
    }

    public function forgot_password(){
        if(isset($_POST['email'])){
            $result = $this->model->change_password($_POST);
            if($result){
                echo json_encode(['status'=>true,'msg'=>'Password change successfully']);
                exit();
            }
            else{
                echo json_encode(['status'=>false,'msg'=>'Not able to change password']);
                exit();
            }
        }
        include('View/forgot_password.php');
    }
}

?>