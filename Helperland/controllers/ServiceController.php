<?php
include("phpmailer/mail.php");

class ServiceController{
    public $model;
    public $base_url = "http://localhost/psd-to-html/Helperland/";

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
                $body = $this->getBodyToSendMailToSPs($result[0]);
                $mail = sendmail($result[1], 'New service request arrive', $body);
                echo json_encode(['sid' => $result[0],'mail' => $mail]);
            }
        }
    }

    public function isServiceAvailable()
    {
        $result = [];
        $error = "";
        if (isset($_POST["userid"])) {
            $userid = $_POST["userid"];
            if (isset($_POST["adid"])) {
                $adid = $_POST["adid"];
                $ondate = $_POST["selecteddate"];
                $result = $this->model->isServiceAvailable($adid, $ondate, $userid);
                if (!$result) {
                    $error = "Another service request has been logged for this address on this date. Please select a different date.";
                }
            }
        }
        echo json_encode(["result" => $result, "error" => $error]);
    }

    public function getBodyToSendMailToSPs($serviceid)
    {
        $result = $this->model->getServiceRequestById($serviceid); 
        $serviceid = substr("000".$result["ServiceRequestId"], -4);
        $startdate = $result["ServiceStartDate"];
        $status = $result["Status"];
        if($status==0){ $status = "New Request"; }
        else if($status==1) { $status = "Assigned To You"; }
        $servicehourlyrate = $result["ServiceHourlyRate"];
        $totalhour = $result["ServiceHours"];
        $extrahour = $result["ExtraHours"];
        $basichour = $totalhour - $extrahour;
        $totalcost = $result["TotalCost"];
        $addressline = $result["AddressLine1"];
        $city = $result["City"];
        $postalcode = $result["PostalCode"];
        $pet = $result['HasPets'];
        if($pet==0){ $pet = "No"; }
        else if($pet==1) { $pet = "Yes"; }
    
        return '
        <html>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style rel="stylesheet">
                *{
                    font-family: "Roboto", sans-serif;
                }
                .cnt{
                    margin: 5px;
                    padding: 12px;
                    background-color:aliceblue;
                }
                .row{
                    margin-bottom: 10px;
                    align-items: center;
                }
               h4{
                   font-weight: 300;
               }
               span{
                   font-weight: 400;
               }
               .address div{
                   background-color:green;
                   color: white;
                   padding: 10px 12px;
               }
               .button, .title{
                   text-align: center;
               }
               b{
                font-size: 14px;
               }
            </style>
        </head>
        <body>
            <div class="cnt">
                <div class="row mt-3 title">
                    <div class=" display-6" style="color:#1d7a8c;font-size:24px;">Service Request Id : <span>'.$serviceid.'</span></div>
                </div><hr style="margin-top: 0px;">
                <div class="row">
                    <div><b>Service Status:-</b> </div>
                    <div><h4><span>'.$status.'<span></h4></div>
                </div>
                <div class="row">
                    <div><b>Service Date:-</b> </div>
                    <div><h4><span>'.$startdate.'<span></h4></div>
                </div>
                <div class="row">
                    <div><b>Total Work:-</b> </div>
                    <div><h4>'.$basichour.' (basic) + '.$extrahour.' (extra) = <span class="totalhour">'.$totalhour.' Hrs. (total)</span></h4></div>
                </div>
                <div class="row">
                    <div><b>Total Bill ('.$servicehourlyrate.'€ per cleaning) :-</b></div>
                    <div><h4><span class="totalbill">'.$totalcost.'€<span></h4></div>
                </div>
                <div class="row">
                    <div><b>Pet At Home:-</b></div>
                    <div><h4><span>'.$pet.'<span></h4></div>
                </div>
                <div class="row address">
                    <div>
                        Address: '.$addressline.', '.$city.', <span>'.$postalcode.'</span>
                    </div>
                </div>
                <div class="row button">
                    <div>
                        <a href="'.$this->base_url.'" class="btn btn-lg btn-primary">Go To Dashboard</a>
                    </div>
                </div>
            </div>
        </body>
    </html>

    ';}
}

?>