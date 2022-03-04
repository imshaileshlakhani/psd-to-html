<?php
include("phpmailer/mail.php");
class CustomerController
{
    public $model;
    public function __construct()
    {
        include('models/Customer.php');
        $this->model = new Customer();
    }

    public function customerDashboard($parameter = "")
    {
        include('View/Customer/Customer-Dashboard.php');
    }

    public function customerData()
    {
        if (isset($_POST)) {
            $paginationData = [];
            $result = [];
            $status = [0, 1, 2];

            $parameter = $_POST['pageName'];
            $paginationData['limit'] = $_POST['limit'];
            $paginationData['page'] = $_POST['page'];

            $TotalRecord = 0;
            if ($parameter != "") {
                switch ($parameter) {
                    case "Dashboard":
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
                        $status = [3, 4];
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
                    case "Favourite":
                        $result = $this->model->show_fav_block_sp($_POST);
                        if (count($result) > 0) {
                            $TotalRecord = $result[0]['Totalrecord'];
                        } else {
                            $TotalRecord = 0;
                        }
                        $paginationData['Totalrecord'] = $TotalRecord;
                        echo json_encode(['favSp' => $result, 'paginationData' => $paginationData]);
                        break;
                    case "setting":
                        $result = $this->model->settingAddress($_POST);
                        echo json_encode(['saddress' => $result]);
                        break;
                    default:
                        echo "no parameter";
                }
            }
        }
    }

    function serviceCancle()
    {
        if (isset($_POST)) {
            $result = $this->model->cancleService($_POST);
            if ($result[0]) {
                if ($result[1] != "") {
                    $body = "Service Request " . $_POST['serviceId'] . " has been cancelled by customer";
                    sendmail([$result[1]], 'Service cancelled ', $body);
                }
                echo json_encode(['update' => $result]);
            }
        }
    }

    function serviceReschedule()
    {
        if (isset($_POST)) {
            $error = "";
            $service = $this->model->getServiceById($_POST['serviceId']);
            if (!is_null($service['ServiceProviderId'])) {
                $startdate = $_POST['date'];
                $spid = $service['ServiceProviderId'];
                $status = [0, 1, 2];
                $results = $this->model->isReschedulePosible($spid, $status, $startdate);
                if (count($results) > 0) {
                    $workinghr = $service['SubTotal'];
                    $select_starttime = $_POST['time'];
                    $select_endtime = $select_starttime + $workinghr;

                    for ($i = 0; $i < count($results); $i++) {
                        $res = $results[$i];
                        $serid = $res["ServiceRequestId"];
                        
                        $service_starttime = $this->convertTimeToStr($res["ServiceStartTime"]);
                        $service_hour = $res["SubTotal"];
                        $service_endtime = $service_starttime + $service_hour;
                        if ($res["ServiceRequestId"] == $_POST['serviceId']) {
                            continue;
                        }
                        // echo $_POST['serviceId'].' '.$serid.' '.$select_starttime.' '.$select_endtime.' '.$service_starttime.' '.$service_endtime;
                        if ($select_starttime == $service_starttime || $select_endtime == $service_endtime || $select_starttime == $service_endtime || ($select_starttime < $service_starttime && $select_endtime > $service_starttime) || ($select_starttime > $service_starttime && $select_starttime < $service_endtime)) {
                            $error = "Another service request has been assigned to the service provider on $startdate from ".$this->convertStrToTime($service_starttime)." to ".$this->convertStrToTime($service_endtime).". Either choose another date or pick up a different time slot";
                            break;
                        }
                    }
                }
            }
            // check user is laready request to reschude service
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
                    if ($result[1] != "") {
                        $body = "Service Request " . $_POST['serviceId'] . " has been rescheduled by customer. New date and time are " . $_POST['date'] . " " . $_POST['time'];
                        sendmail([$result[1]], 'Service rescheduled ', $body);
                    }
                }
            }
            echo json_encode(['dateUpdate' => $result,'error'=>$error]);
        }
    }

    /*------------ Convert  format num(10.5) to time(10:30) -------------*/
    private function convertStrToTime($str)
    {
        $hour = substr("0" + floor($str), -2);
        $min = "00";
        if ($hour < $str) {
            $min = "30";
        }
        return $hour . ":" . $min;
    }

    /*------------ Convert time(10:30) format to num(10.5) -------------*/
    private function convertTimeToStr($time)
    {
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


    function favBlockSp()
    {
        if (isset($_POST)) {
            $result = $this->model->fav_block_sp($_POST);
            echo json_encode(['status' => $result]);
        }
    }

    public function addeditAddress()
    {
        if (isset($_POST)) {
            $address = $this->model->add_edit_address($_POST);
            if ($address) {
                echo json_encode(['address' => $address]);
            } else {
                echo json_encode(['errormsg' => 'Please try later currently not able to add or edit address', 'address' => $address]);
            }
        }
    }

    public function editSetting()
    {
        if (isset($_POST)) {
            $userdata = $this->model->editSettingDetails($_POST);
            if (count($userdata) > 0) {
                $_SESSION['userdata'] = $userdata;
                echo json_encode(['save' => $userdata]);
            }
        }
    }

    public function changePassword()
    {
        if (isset($_POST)) {
            $success = $this->model->changeOldPassword($_POST);
            if ($success['yes']) {
                echo json_encode(['success' => $success]);
            } else {
                echo json_encode(['success' => $success]);
            }
        }
    }

    public function addressDelete()
    {
        if (isset($_POST)) {
            $success = $this->model->deleteAddress($_POST);
            if ($success) {
                echo json_encode(['successmsg' => 'Address deleted successfully', 'status' => true]);
            } else {
                echo json_encode(['errormsg' => 'Not able to delete address', 'status' => false]);
            }
        }
    }

    public function giveRatting()
    {
        if (isset($_POST)) {
            $success = $this->model->saveRatting($_POST);
            if ($success) {
                echo json_encode(['successmsg' => 'Ratting save successfully', 'status' => true]);
            } else {
                echo json_encode(['errormsg' => 'Not able to rate service provider', 'status' => false]);
            }
        }
    }

    public function getAddress()
    {
        if (isset($_POST)) {
            $details = $this->model->getAddressById($_POST);
            if ($details) {
                echo json_encode(['details' => $details]);
            }
        }
    }
}
