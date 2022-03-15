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
                $email = !empty($data['email']) ? $data['email'] : 1;

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.TotalCost,servicerequest.ServiceProviderId,servicerequest.SubTotal,servicerequest.Status,servicerequest.ServiceStartDate,servicerequestaddress.*,concat(cu.FirstName, ' ', cu.LastName) AS CFullName,concat(sp.FirstName, ' ', sp.LastName) AS SpFullName,sp.UserProfilePicture FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user AS cu ON cu.UserId = servicerequest.UserId LEFT JOIN user AS sp ON sp.UserId = servicerequest.ServiceProviderId WHERE $customer AND $servicer AND $sid AND $postal AND $status LIMIT $offset,$showrecord";

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

        public function userDetails($data){
            $result = [];
            if(isset($data['userid'])){
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;

                $total = $this->getTotalServiceByUserId($data);
                if(is_null($total) || $total == 0){
                   return [];
                }

                $sql = "SELECT user.UserId, concat(user.FirstName,' ',user.LastName) AS FullName,user.UserTypeId,user.Mobile,user.CreatedDate,user.IsActive,useraddress.PostalCode FROM user LEFT JOIN useraddress ON user.UserId = useraddress.UserId GROUP BY user.UserId LIMIT $offset,$showrecord";

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
            if($pageName == "srequest"){
                $customer = !empty($data['customer']) ? 'servicerequest.UserId='.$data['customer'] : 1;
                $servicer = !empty($data['servicer']) ? 'servicerequest.ServiceProviderId='.$data['servicer'] : 1;
                $sid = !empty($data['sid']) ? 'servicerequest.ServiceRequestId='.$data['sid'] : 1;
                $postal = !empty($data['postal']) ? 'servicerequestaddress.PostalCode='.$data['postal'] : 1;
                $status = !empty($data['status']) ? ($data['status'] == -1 ? 'servicerequest.Status=0' : 'servicerequest.Status='.$data['status']) : 1;
                $email = !empty($data['email']) ? $data['email'] : 1;

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.TotalCost,servicerequest.ServiceProviderId,servicerequest.SubTotal,servicerequest.Status,servicerequest.ServiceStartDate,servicerequestaddress.*,concat(cu.FirstName, ' ', cu.LastName) AS CFullName,concat(sp.FirstName, ' ', sp.LastName) AS SpFullName,sp.UserProfilePicture FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user AS cu ON cu.UserId = servicerequest.UserId LEFT JOIN user AS sp ON sp.UserId = servicerequest.ServiceProviderId WHERE $customer AND $servicer AND $sid AND $postal AND $status";

                // AND servicerequestaddress.Email = '$email'
            }
            else{
                $sql = "SELECT user.UserId FROM user";
            }
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
    }
?>