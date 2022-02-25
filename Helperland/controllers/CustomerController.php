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
                        echo $parameter . " tab-content";
                        break;
                    case "setting":
                        echo $parameter . " tab-content";
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
}

?>
