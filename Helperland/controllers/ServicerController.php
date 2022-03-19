<?php
include('Calendar/Calendar.php');
class ServicerController{
    public $model;
    // public $data = [];
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
            // $this->data["date"] = $_POST['date'];
            
            if ($parameter != "") {
                switch ($parameter) {
                    case "New":
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        if (count($result) > 0)
                            $TotalRecord = $result[0]['Totalrecord'];
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "Upcoming":
                        $status = [2];
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        if (count($result) > 0)
                            $TotalRecord = $result[0]['Totalrecord'];
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "History":
                        $status = $this->getHistoryArea($_POST['pstatus']);
                        $_POST['status'] = $status;
                        $result = $this->model->serviceDetails($_POST);
                        if (count($result) > 0)
                            $TotalRecord = $result[0]['Totalrecord'];
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "Ratings":
                        $ratingArea = $this->getRatingArea($_POST['rstatus']);
                        $_POST['ratingS'] = $ratingArea[0];
                        $_POST['ratingE'] = $ratingArea[1];
                        $result = $this->model->getRatingsBySpId($_POST);
                        if (count($result) > 0)
                            $TotalRecord = $result[0]['Totalrecord'];
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['service' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "Schedule":
                        if(isset($this->data["date"])){
                            $date = $this->data["date"];
                        }else{
                            $date = date("Y-m-d");
                        }
                        //echo $date;
                        $calendar = new Calendar($date);
                        $results = $this->model->getServiceByMonthAndYear($_POST['userid'], $date, "(2)");
                        //print_r($result);
                        if(count($results)>0){
                            $i=0;
                            foreach($results as $result){
                                $service_starttime = $result["ServiceStartTime"];
                                $service_endtime = $this->convertStrToTime($result["ServiceHours"] + $this->convertTimeToStr($service_starttime));
                                $calendar->add_event($service_starttime." - ".$service_endtime, $result["StartDate"], 1, "appcolor",$i++);
                            }
                        }
                        $html = $calendar->getCalendarHTML();
                        echo json_encode(['html' => $html, 'service' => $results]);
                        break;
                    case "Block":
                        $result = $this->model->show_block_user($_POST);
                        if (count($result) > 0)
                            $TotalRecord = $result[0]['Totalrecord'];
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

    public function getHistoryArea($pstatus){
        if($pstatus == "Completed")
            $status = [4];
        else if($pstatus == "Cancelled")
            $status = [3];
        else
            $status = [3,4];
        return $status;
    }

    public function getRatingArea($rstatus){
        if($rstatus == "Bad"){
            $ratingS = 0;
            $ratingE = 1;
        }
        else if($rstatus == "Fair"){
            $ratingS = 1;
            $ratingE = 2;
        }
        else if($rstatus == "Average"){
            $ratingS = 2;
            $ratingE = 3;
        }
        else if($rstatus == "Good"){
            $ratingS = 3;
            $ratingE = 4;
        }
        else if($rstatus == "Excellent"){
            $ratingS = 4;
            $ratingE = 5;
        }
        else{
            $ratingS = 0;
            $ratingE = 5;
        }
        return [$ratingS,$ratingE];
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

    public function serviceComplete(){
        if (isset($_POST)) {
            $result = $this->model->completeService($_POST);
            if ($result) {
                echo json_encode(['save' => $result]);
            }
        }
    }

    public function serviceAccept(){
        if (isset($_POST)) {
            $error = "";
            $startdate = $_POST['startdate'];
            $results = $this->model->getServiceBySpId($_POST['userid'],$startdate);
            if (count($results) > 0) {
                $workinghr = $_POST['workinghr'];
                $select_starttime = $this->convertTimeToStr($_POST['starttime']);
                $select_endtime = $select_starttime + $workinghr;
                for ($i = 0; $i < count($results); $i++) {
                    $res = $results[$i];
                    // print_r($results);
                    $service_starttime = $this->convertTimeToStr($res["ServiceStartTime"]);
                    $service_hour = $res["ServiceHours"];
                    $service_endtime = $service_starttime + $service_hour;
                    // echo $select_starttime.' '.$select_endtime.' '.$service_starttime.' '.$service_endtime;
                    if ($select_starttime == $service_starttime || $select_endtime == $service_endtime || $select_starttime == $service_endtime || $select_endtime == $service_starttime ||
                    (($select_starttime < $service_starttime && $select_endtime > $service_starttime) || ($select_starttime < $service_starttime && ($service_starttime - $select_endtime) < 1)) ||
                    (($select_starttime > $service_starttime && $select_starttime < $service_endtime) || ($select_starttime > $service_starttime && ($select_starttime - $service_endtime) < 1))) {
                        $error = "Another service request ".$res["ServiceRequestId"]." has already been accepted which has time overlap with this service request. You can’t pick this one!";
                            break;
                        }
                }
            }
            // echo $error;
            $result = [];
            if(empty($error)){
                $result = $this->model->acceptService($_POST);
                if ($result[0]) {
                    // if ($result[2] != "") {
                    //     $body = "Service Request " . $_POST['serviceId'] . " has been Accepted by servicer.";
                    //     sendmail([$result[1]], 'Service rescheduled ', $body);
                    // }
                }else{
                    $error = $result[1];
                }
            }
            echo json_encode(['error'=>$error]);
        }
    }

    /*------------ Convert  format num(10.5) to time(10:30) -------------*/
    private function convertStrToTime($str){
        $hour = substr("0" + floor($str), -2);
        $min = "00";
        if ($hour < $str) {
            $min = "30";
        }
        return $hour . ":" . $min;
    }

    /*------------ Convert time(10:30) format to num(10.5) -------------*/
    private function convertTimeToStr($time){
        $time = explode(":", $time);
        $hour = +$time[0];
        $min = 0.0;
        if (count($time) == 2) {
            $min = +$time[1];
            if ($min != 0) {
                $min = 0.5;
            }
        }
        return $hour + $min;
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