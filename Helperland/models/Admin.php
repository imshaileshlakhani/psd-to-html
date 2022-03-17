<?php
    include("models/connection.php");
    class Admin extends Connection{
        public function __construct(){
            $this->conn = $this->connect();
        }

        public function serviceDetails($data){
            $result = [];
            if(isset($data['userid'])){
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;
                $avgRatting = 0.0;

                $total = $this->getTotalServiceByUserId($data);
                if(is_null($total) || $total == 0){
                   return [];
                }

                $customer = !empty($data['customer']) ? 'servicerequest.UserId='.$data['customer'] : 1;
                $servicer = !empty($data['servicer']) ? 'servicerequest.ServiceProviderId='.$data['servicer'] : 1;
                $sid = !empty($data['sid']) ? 'servicerequest.ServiceRequestId='.$data['sid'] : 1;
                $status = !empty($data['status']) ? ($data['status'] == -1 ? 'servicerequest.Status=0' : 'servicerequest.Status='.$data['status']) : 1;
                $postal = !empty($data['postal']) ? 'servicerequestaddress.PostalCode='.$data['postal'] : 1;
                $fdate = !empty($data['fdate']) ? $data['fdate'].' 00:00:00.000' : "1900-01-01 00:00:00.000";
                $tdate = !empty($data['tdate']) ? $data['tdate'].' 23:59:00.000' : "3000-01-01 23:59:00.000";
                $email = !empty($data['email']) ? "servicerequestaddress.Email='".$data['email']."'" : 1;

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.TotalCost,servicerequest.ServiceProviderId,servicerequest.SubTotal,servicerequest.Status,servicerequest.ServiceStartDate,servicerequestaddress.*,concat(cu.FirstName, ' ', cu.LastName) AS CFullName,concat(sp.FirstName, ' ', sp.LastName) AS SpFullName,sp.UserProfilePicture FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user AS cu ON cu.UserId = servicerequest.UserId LEFT JOIN user AS sp ON sp.UserId = servicerequest.ServiceProviderId WHERE $customer AND $servicer AND $sid AND $postal AND $status AND $email AND servicerequest.ServiceStartDate BETWEEN '$fdate' AND '$tdate' LIMIT $offset,$showrecord";
                // AND servicerequest.ServiceStartDate BETWEEN $fdate AND $tdate

                $result = $this->conn->query($sql);
                $rows = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if($row['ServiceProviderId'] != null){
                            $avgRatting = $this->getRattingBySpId($row['ServiceProviderId']);
                            if(is_null($avgRatting['avgrating'])){
                                $avgRatting['avgrating'] = "0.0";
                                $row['avgRatting'] = $avgRatting;
                            }else{
                                $row['avgRatting'] = $avgRatting;
                            }
                        }
                        $row['Totalrecord'] = $total;
                        array_push($rows, $row);
                    }
                    $result = $rows;
                } else {
                    $result = [];
                }
            }
            return $result; 
        }

        public function getCustomerName(){
            $customers = [];
            $sql = "SELECT UserId,concat(FirstName,' ',LastName) AS FullName FROM user WHERE UserTypeId = 1";
            $result = $this->conn->query($sql);
            $rows = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    array_push($rows, $row);
                }
                $customers = $rows;
            }
            else{
                $customers = [];
            }
            return $customers;
        }

        public function getServicerName(){
            $servicer = [];
            $sql = "SELECT UserId,concat(FirstName,' ',LastName) AS FullName FROM user WHERE UserTypeId = 2";
            $result = $this->conn->query($sql);
            $rows = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    array_push($rows, $row);
                }
                $servicer = $rows;
            }
            else{
                $servicer = [];
            }
            return $servicer;
        }

        public function getUserName(){
            $users = [];
            $sql = "SELECT UserId,concat(FirstName,' ',LastName) AS FullName FROM user";
            $result = $this->conn->query($sql);
            $rows = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    array_push($rows, $row);
                }
                $users = $rows;
            }
            else{
                $users = [];
            }
            return $users;
        }

        public function userDetails($data){
            $result = [];
            if(isset($data['userid'])){
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;

                $total = $this->getTotalServiceByUserId($data);
                if(is_null($total) || $total == 0){
                   return [];
                }

                $utype = !empty($data['utype']) ? 'user.UserTypeId='.$data['utype'] : 1;
                $postal = !empty($data['postal']) ? 'useraddress.PostalCode='.$data['postal'] : 1;
                $mobile = !empty($data['mobile']) ? 'useraddress.Mobile='.$data['mobile'] : 1;
                $user = !empty($data['user']) ? 'user.UserId='.$data['user'] : 1;
                $fdate = !empty($data['fdate']) ? $data['fdate'].' 00:00:00.000' : "1900-01-01 00:00:00.000";
                $tdate = !empty($data['tdate']) ? $data['tdate'].' 23:59:00.000' : "3000-01-01 23:59:00.000";
                $email = !empty($data['email']) ? "user.Email='".$data['email']."'" : 1;

                $sql = "SELECT user.UserId, concat(user.FirstName,' ',user.LastName) AS FullName,user.UserTypeId,user.Mobile,user.CreatedDate,user.IsApproved,useraddress.PostalCode FROM user LEFT JOIN useraddress ON user.UserId = useraddress.UserId WHERE $utype AND $postal AND $mobile AND $user AND $email AND user.CreatedDate BETWEEN '$fdate' AND '$tdate' GROUP BY user.UserId LIMIT $offset,$showrecord";
                // AND user.CreatedDate '$fdate' AND '$tdate'

                $result = $this->conn->query($sql);
                $rows = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['Totalrecord'] = $total;
                        array_push($rows, $row);
                    }
                    $result = $rows;
                } else {
                    $result = [];
                }
            }
            return $result; 
        }

        public function getTotalServiceByUserId($data){
            $total = 0;
            $pageName = $data['pageName'];
            $fdate = !empty($data['fdate']) ? $data['fdate'].' 00:00:00.000' : "1900-01-01 00:00:00.000";
            $tdate = !empty($data['tdate']) ? $data['tdate'].' 23:59:00.000' : "3000-01-01 23:59:00.000";
            
            if($pageName == "srequest"){
                $customer = !empty($data['customer']) ? 'servicerequest.UserId='.$data['customer'] : 1;
                $servicer = !empty($data['servicer']) ? 'servicerequest.ServiceProviderId='.$data['servicer'] : 1;
                $sid = !empty($data['sid']) ? 'servicerequest.ServiceRequestId='.$data['sid'] : 1;
                $postal = !empty($data['postal']) ? 'servicerequestaddress.PostalCode='.$data['postal'] : 1;
                $status = !empty($data['status']) ? ($data['status'] == -1 ? 'servicerequest.Status=0' : 'servicerequest.Status='.$data['status']) : 1;
                $email = !empty($data['email']) ? "servicerequestaddress.Email='".$data['email']."'" : 1;

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.TotalCost,servicerequest.ServiceProviderId,servicerequest.SubTotal,servicerequest.Status,servicerequest.ServiceStartDate,servicerequestaddress.*,concat(cu.FirstName, ' ', cu.LastName) AS CFullName,concat(sp.FirstName, ' ', sp.LastName) AS SpFullName,sp.UserProfilePicture FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user AS cu ON cu.UserId = servicerequest.UserId LEFT JOIN user AS sp ON sp.UserId = servicerequest.ServiceProviderId WHERE $customer AND $servicer AND $sid AND $postal AND $status AND $email AND servicerequest.ServiceStartDate BETWEEN '$fdate' AND '$tdate'";
                // AND servicerequest.ServiceStartDate BETWEEN $fdate AND $tdate
            }
            else{
                $utype = !empty($data['utype']) ? 'user.UserTypeId='.$data['utype'] : 1;
                $postal = !empty($data['postal']) ? 'useraddress.PostalCode='.$data['postal'] : 1;
                $mobile = !empty($data['mobile']) ? 'useraddress.Mobile='.$data['mobile'] : 1;
                $user = !empty($data['user']) ? 'user.UserId='.$data['user'] : 1;
                $email = !empty($data['email']) ? "user.Email='".$data['email']."'" : 1;

                $sql = "SELECT user.UserId, concat(user.FirstName,' ',user.LastName) AS FullName,user.UserTypeId,user.Mobile,user.CreatedDate,user.IsActive,useraddress.PostalCode FROM user LEFT JOIN useraddress ON user.UserId = useraddress.UserId WHERE $utype AND $postal AND $mobile AND $user AND $email AND user.CreatedDate BETWEEN '$fdate' AND '$tdate' GROUP BY user.UserId";
            }

            // echo $sql;
            
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $total = $result->num_rows;
            }
            else{
                $total = 0;
            }
            return $total;
        }

        public function getRattingBySpId($spid){
            $avgRatting = 0;
            $sql = "SELECT AVG(Ratings) AS avgrating FROM rating WHERE RatingTo = $spid";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $avgRatting = $result->fetch_assoc();
            }
            return $avgRatting;
        }

        public function approvedUser($data){
            $userid = $data['userid'];
            $isApproved = 0;
            $isApproved = $data['IsApproved'] == 0 ? 1 : 0;
            $sql = "UPDATE user SET IsApproved = $isApproved WHERE UserId = $userid";
            $result = $this->conn->query($sql);
            if ($result) {
                return true;
            }
            return false;
        }

        public function serviceCancle($data){
            $serviceId = $data['serviceId'];
            $sql = "UPDATE servicerequest SET Status = 3 WHERE ServiceRequestId = $serviceId";
            $result = $this->conn->query($sql);
            if ($result) {
                return true;
            }
            return false;
        }

        public function refundPayment($data){
            $serviceId = $data['serviceId'];
            $payment = $data['payment'];
            $sql = "UPDATE servicerequest SET Status = 5,RefundedAmount = $payment WHERE ServiceRequestId = $serviceId";
            $result = $this->conn->query($sql);
            if ($result) {
                return true;
            }
            return false;
        }

        public function getServiceById($serviceId){
            $sql = "SELECT * FROM servicerequest WHERE ServiceProviderId != 'NULL' AND ServiceRequestId = $serviceId ";
            $result = $this->conn->query($sql);
            if($result->num_rows > 0){
                return $result->fetch_assoc();
            }
            else{
                return [];
            }
        }

        public function isReschedulePosible($favsp,$status,$startdate){
            $sql = "SELECT sr.ServiceRequestId, DATE_FORMAT(sr.ServiceStartDate, '%H:%i') as ServiceStartTime, sr.SubTotal, sr.Status, user.Email FROM servicerequest AS sr JOIN user ON user.UserId = sr.ServiceProviderId WHERE sr.ServiceProviderId = $favsp AND sr.Status IN (" . implode(',', $status). ") AND sr.ServiceStartDate LIKE '%$startdate%';";
            $services = $this->conn->query($sql);
            $rows = [];
            if($services->num_rows > 0){
            // check any slot time with selected time
                while($row = $services->fetch_assoc()){
                    array_push($rows,$row);
                }
            }
            return $rows;
        }

        public function rescheduleService($data,$status,$record_version){
            $serviceId = $data['serviceId'];
            $date = $data['date'];
            $start_time = $data['time'];
            $comment = $data['comment'];

            // set date format 
            $date = new DateTime($date);
            $date->setTime(floor($start_time), floor($start_time) == $start_time ? "00" : (("0." . substr($start_time, -1) * 60) * 100));
            $cleaningstartdate = $date->format('Y-m-d H:i:s');

            $result = "";
            $sql = "UPDATE servicerequest SET ServiceStartDate = '$cleaningstartdate', Comments = '$comment', Status = $status, RecordVersion = $record_version WHERE ServiceRequestId = $serviceId";
            if($this->conn->query($sql) == TRUE){
                $email = $this->getSpEmailByServiceId($serviceId);
                $address = $this->updateserviceAddress($data);
				$result = true; 
			}
			else{
				$result = false;
			}
            return [$result,$email];
        }

        public function updateserviceAddress($data){
            $serviceId = $data['serviceId'];
            $address = $data['street'].' '.$data['house'];
            $postal = $data['postal'];
            $city = $data['city'];

            $result = "";
            $sql = "UPDATE servicerequestaddress SET AddressLine1 = '$address', PostalCode = '$postal', City = '$city' WHERE ServiceRequestId = $serviceId";
            if($this->conn->query($sql) == TRUE){
				$result = true; 
			}
			else{
				$result = false;
			}
            return $result;
        }

        public function getSpEmailByServiceId($sid){
            $email = "";
            $sql = "SELECT user.Email FROM servicerequest JOIN user ON servicerequest.ServiceProviderId = user.UserId WHERE servicerequest.ServiceRequestId = $sid";
            $result = $this->conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $email = $row['Email'];
            }
            return $email;
        }
    }
?>