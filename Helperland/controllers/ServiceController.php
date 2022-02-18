<?php
include("phpmailer/mail.php");

class ServiceController{
    public $model;
    public $base_url = "http://localhost/psd-to-html/Helperland/";
    public $error_url = "http://localhost/psd-to-html/Helperland/?controller=Public&function=error";

    public function __construct(){
        include("models/Service.php");
        $this->model = new Service();
    }
    
    public function service(){
        include('View/book_service.php');
    }

    public function postal(){
        if(isset($_POST['postal'])){
            $result = $this->model->is_validPostal($_POST);
            if(count($result) > 0){
                echo json_encode($result);
            }
        }
    }

    public function get_Address_Favsp(){
        if(isset($_POST['zipcode'])){
            $address = $this->model->get_address($_POST);
            $fav = $this->model->get_favSp($_POST);
            if(count($address) > 0 || count($fav) > 0){
                echo json_encode(['address' => $address,'fav' => $fav]);
            }
        }
    }

    public function addAddress(){
        if(isset($_POST)){
            $address = $this->model->add_address($_POST);
            if(count($address) > 0){
                echo json_encode(['address' => $address]);
            }
        }
    }

    public function bookService(){
        if(isset($_POST)){
            $result = $this->model->book_service($_POST);
            if($result[0]){
                $mail = sendmail($result[1], 'df', 'df');
                echo json_encode(['sid' => $result[0],'mail' => $mail]);
            }
        }
    }
}

?>