<?php
class ServicerController{
    public $model;
    public function __construct(){
        include('models/Servicer.php');
        $this->model = new Servicer();
    }

    public function ServicerDashboard(){
        include('View/Servicer/Servicer-Dashboard.php');
    }

    public function servicerData(){
        if (isset($_POST)) {
            $paginationData = [];
            $result = [];
            $parameter = $_POST['pageName'];
            $status = [0,1];

            $paginationData['limit'] = $_POST['limit'];
            $paginationData['page'] = $_POST['page'];
            $TotalRecord = 0;

            if ($parameter != "") {
                switch ($parameter) {
                    case "New":
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        if (count($result) > 0) {
                            $TotalRecord = $result[0]['Totalrecord'];
                        } else {
                            $TotalRecord = 0;
                        }
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "Upcoming":
                        $status = [2];
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        if (count($result) > 0) {
                            $TotalRecord = $result[0]['Totalrecord'];
                        } else {
                            $TotalRecord = 0;
                        }
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "History":
                        $status = [3,4];
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        if (count($result) > 0) {
                            $TotalRecord = $result[0]['Totalrecord'];
                        } else {
                            $TotalRecord = 0;
                        }
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "Ratings":
                        $result = $this->model->getRatingsBySpId($_POST);
                        if (count($result) > 0) {
                            $TotalRecord = $result[0]['Totalrecord'];
                        } else {
                            $TotalRecord = 0;
                        }
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "Block":
                        $result = $this->model->show_block_user($_POST);
                        if (count($result) > 0) {
                            $TotalRecord = $result[0]['Totalrecord'];
                        } else {
                            $TotalRecord = 0;
                        }
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "setting":
                        $result = $this->model->getAddressById($_POST);
                        echo json_encode(['address'=>$result]);
                        break;
                    default:
                        echo "no parameter";
                }
            }
        }
    }

    public function avtar(){
        if(isset($_POST)){
            $_POST['avtarName'] = $_POST['avtar'].'.png';
            $result = $this->model->setAvtar($_POST);
            if($result){
                echo json_encode(['status'=>$result]);
            }
            else{
                echo json_encode(['status'=>$result]);
            }
        }
    }

    public function editSetting(){
        if (isset($_POST)) {
            $userdata = $this->model->editSettingDetails($_POST);
            if (count($userdata) > 0) {
                $_SESSION['userdata'] = $userdata;
                echo json_encode(['save' => $userdata]);
            }
        }
    }

    function serviceCancle(){
        if (isset($_POST)) {
            $result = $this->model->cancleService($_POST);
            if ($result) {
                // if ($result[1] != "") {
                //     $body = "Service Request " . $_POST['serviceId'] . " has been cancelled by customer";
                //     sendmail([$result[1]], 'Service cancelled ', $body);
                // }
                echo json_encode(['update' => $result]);
            }
        }
    }

    public function serviceDetails(){
        if (isset($_POST)) {
            $result = $this->model->serviceDetailsByServiceId($_POST);
            if (count($result) > 0) {
                echo json_encode(['service' => $result]);
            }
        }
    }

    function blockCustomer(){
        if (isset($_POST)) {
            $result = $this->model->blockCustomer($_POST);
            echo json_encode(['status' => $result]);
        }
    }

    public function changePassword(){
        if (isset($_POST)) {
            $success = $this->model->changeOldPassword($_POST);
            if ($success['yes']) {
                echo json_encode(['success' => $success]);
            } else {
                echo json_encode(['success' => $success]);
            }
        }
    }

}
?>