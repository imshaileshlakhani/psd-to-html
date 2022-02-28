<?php
class CustomerController{
    public $model;
    public function __construct(){
        include('models/Customer.php');
        $this->model = new Customer();
    }

    public function customerDashboard($parameter = ""){
        include('View/Customer/Customer-Dashboard.php');
    }

    public function customerData(){
        if(isset($_POST)){
            $paginationData = [];
            $result = [];
            $status = [0,1];

            $parameter = $_POST['pageName'];
            $paginationData['limit'] = $_POST['limit'];
            $paginationData['page'] = $_POST['page'];
            
            $TotalRecord = 0;
            if ($parameter != "") {
                switch ($parameter) {
                    case "Dashboard":
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        $TotalRecord = $result[0]['Totalrecord'];
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service'=>$result,'paginationData'=>$paginationData]);
                        break;
                    case "History":
                        $status = [3,4];
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        $TotalRecord = $result[0]['Totalrecord'];
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service'=>$result,'paginationData'=>$paginationData]);
                        break;
                    case "Favourite":
                        $result = $this->model->show_fav_block_sp($_POST);
                        $TotalRecord = $result[0]['Totalrecord'];
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['favSp'=>$result,'paginationData'=>$paginationData]);
                        break;
                    case "setting":
                        $result = $this->model->settingAddress($_POST);
                        echo json_encode(['saddress'=>$result]);
                        break;
                    default:
                        echo "no parameter";
                }
            }
        }
    }

    function serviceCancle(){
        if(isset($_POST)){
            $result = $this->model->cancleService($_POST);
            echo json_encode(['update'=>$result]);
        }
    }

    function serviceReschedule(){
        if(isset($_POST)){
            $result = $this->model->rescheduleService($_POST);
            echo json_encode(['dateUpdate'=>$result]);
        }
    }

    function favBlockSp(){
        if(isset($_POST)){
            $result = $this->model->fav_block_sp($_POST);
            echo json_encode(['status'=>$result]);
        }
    }

    public function addAddress(){
        if(isset($_POST)){
            $address = $this->model->add_address($_POST);
            if($address){
                echo json_encode(['address' => $address]);
            }
        }
    }

    public function editSetting(){
        if(isset($_POST)){
            $userdata = $this->model->editSettingDetails($_POST);
            if(count($userdata) > 0){
                $_SESSION['userdata'] = $userdata;
                echo json_encode(['save' => $userdata]);
            }
        }
    }
    public function changePassword(){
        if(isset($_POST)){
            $success = $this->model->changeOldPassword($_POST);
            if($success){
                echo json_encode(['success'=>$success]);
            }
        }
    }
}

?>
