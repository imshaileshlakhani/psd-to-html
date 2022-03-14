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
    
                $parameter = $_POST['pageName'];
                $paginationData['limit'] = $_POST['limit'];
                $paginationData['page'] = $_POST['page'];
    
                $TotalRecord = 0;
                if ($parameter != "") {
                    switch ($parameter) {
                        case "srequest":
                            $result = $this->model->serviceDetails($_POST);
                            if (count($result) > 0)
                                $TotalRecord = $result[0]['Totalrecord'];
                            $paginationData['Totalrecord'] = $TotalRecord;
                            echo json_encode(['record' => $result, 'paginationData' => $paginationData]);
                            break;
                        case "umanagement":
                            $result = $this->model->userDetails($_POST);
                            if (count($result) > 0)
                                $TotalRecord = $result[0]['Totalrecord'];
                            $paginationData['Totalrecord'] = $TotalRecord;
                            echo json_encode(['record' => $result, 'paginationData' => $paginationData]);
                            break;
                        default:
                            echo "no parameter";
                    }
                }
            }
        }
    }
?>