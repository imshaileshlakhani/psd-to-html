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
            $parameter = $_POST['pageName'];

            if ($parameter != "") {
                switch ($parameter) {
                    case "New":
                        echo "New";
                        break;
                    case "Upcoming":
                        echo "Upcoming";
                        break;
                    case "History":
                        echo "History";
                        break;
                    case "Ratings":
                        echo "Ratings";
                        break;
                    case "Block":
                        echo "Block";
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