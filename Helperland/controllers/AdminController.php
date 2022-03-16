<?php
    class AdminController{
        public $model;
        public function __construct(){
            include('models/Admin.php');
            $this->model = new Admin();
        }

        public function adminDashboard(){
            include('View/Admin/Admin-Dashboard.php');
        }

        public function adminData(){
            if (isset($_POST)) {
                $paginationData = [];
                $result = [];
                $customers = [];
                $servicer = [];
                $users = [];
    
                $parameter = $_POST['pageName'];
                $paginationData['limit'] = $_POST['limit'];
                $paginationData['page'] = $_POST['page'];
    
                $TotalRecord = 0;
                if ($parameter != "") {
                    switch ($parameter) {
                        case "srequest":
                            $customers = $this->model->getCustomerName();
                            $servicer = $this->model->getServicerName();
                            $result = $this->model->serviceDetails($_POST);
                            if (count($result) > 0)
                                $TotalRecord = $result[0]['Totalrecord'];
                            $paginationData['Totalrecord'] = $TotalRecord;
                            echo json_encode(['record' => $result,'customer' => $customers, 'servicer' => $servicer,'paginationData' => $paginationData]);
                            break;
                        case "umanagement":
                            $users = $this->model->getUserName();
                            $result = $this->model->userDetails($_POST);
                            if (count($result) > 0)
                                $TotalRecord = $result[0]['Totalrecord'];
                            $paginationData['Totalrecord'] = $TotalRecord;
                            echo json_encode(['record' => $result,'user' => $users , 'paginationData' => $paginationData]);
                            break;
                        default:
                            echo "no parameter";
                    }
                }
            }
        }

        public function userApproved(){
            if(isset($_POST)){
                $result = $this->model->approvedUser($_POST);
                if($result){
                    echo json_encode(['status' => $result]);
                }
            }
        }

        public function cancleService(){
            if(isset($_POST)){
                $result = $this->model->serviceCancle($_POST);
                if($result){
                    echo json_encode(['status' => $result]);
                }
            }
        }

        public function refund(){
            if(isset($_POST)){
                $result = $this->model->refundPayment($_POST);
                if($result){
                    echo json_encode(['status' => $result]);
                }
            }
        }
    }
?>