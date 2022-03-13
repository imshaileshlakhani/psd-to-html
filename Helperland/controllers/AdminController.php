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
                // $paginationData = [];
                $result = [];
    
                $parameter = $_POST['pageName'];
                // $paginationData['limit'] = $_POST['limit'];
                // $paginationData['page'] = $_POST['page'];
    
                $TotalRecord = 0;
                if ($parameter != "") {
                    switch ($parameter) {
                        case "srequest":
                            $result = $this->model->serviceDetails($_POST);
                            echo json_encode(['service' => $result]);
                            break;
                        case "umanagement":
                            echo "umanagement";
                            // echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                            break;
                        default:
                            echo "no parameter";
                    }
                }
            }
        }
    }
?>