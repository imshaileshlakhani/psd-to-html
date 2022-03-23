<?php
include("phpmailer/mail.php");
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

        function serviceReschedule(){
            if (isset($_POST)) {
                $error = "";
                $service = $this->model->getServiceById($_POST['serviceId']);
                if (!is_null($service['ServiceProviderId'])) {
                    $startdate = $_POST['date'];
                    $spid = $service['ServiceProviderId'];
                    $status = [0, 1, 2];
                    $results = $this->model->isReschedulePosible($spid, $status, $startdate);
                    if (count($results) > 0) {
                        $workinghr = $service['ServiceHours'];
                        $select_starttime = $_POST['time'];
                        $select_endtime = $select_starttime + $workinghr;
    
                        for ($i = 0; $i < count($results); $i++) {
                            $res = $results[$i];
                            $serid = $res["ServiceRequestId"];
                            
                            $service_starttime = $this->convertTimeToStr($res["ServiceStartTime"]);
                            $service_hour = $res["ServiceHours"];
                            $service_endtime = $service_starttime + $service_hour;
                            if ($res["ServiceRequestId"] == $_POST['serviceId']) {
                                continue;
                            }
                            
                            if ($select_starttime == $service_starttime || $select_endtime == $service_endtime || $select_starttime == $service_endtime || $select_endtime == $service_starttime ||
                            (($select_starttime < $service_starttime && $select_endtime > $service_starttime) || ($select_starttime < $service_starttime && ($service_starttime - $select_endtime) < 1)) || (($select_starttime > $service_starttime && $select_starttime < $service_endtime) || ($select_starttime > $service_starttime && ($select_starttime - $service_endtime) < 1))) {
                                // echo $_POST['serviceId'].' '.$serid.' '.$select_starttime.' '.$select_endtime.' '.$service_starttime.' '.$service_endtime;
                                $error = "Another service request ".$serid." has been assigned to the service provider on $startdate from ".$this->convertStrToTime($service_starttime)." to ".$this->convertStrToTime($service_endtime).". Either choose another date or pick up a different time slot";
                                break;
                            }
                        }
                    }
                }
                // check user is aready request to reschude service
                $record_version = 0;
                $status = $service["Status"];
                if($service["Status"]==2 && (is_null($service["RecordVersion"]) || $service["RecordVersion"]==0)){
                    $record_version = 1;
                    $status = 1;
                }else if($service["Status"]==1 && $service["RecordVersion"]==1){
                    $error = "You can't rescheduled service request.untill Your SP will accept it";
                }
                $result = [];
                if(empty($error)){
                    $result = $this->model->rescheduleService($_POST,$status,$record_version);
                    if ($result[0]) {
                        $body = "Service Request " . $_POST['serviceId'] . " has been rescheduled by Admin. New date is " . $_POST['date'] . " and time is " . $this->convertStrToTime($_POST['time']);
                        if ($result[1] != "") {
                            sendmail([$result[1]], 'Service rescheduled ', $body);
                        }
                        if ($result[2] != "") {
                            sendmail([$result[2]], 'Service rescheduled ', $body);
                        }
                    }
                }
                echo json_encode(['dateUpdate' => $result,'error'=>$error]);
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
    }
?>