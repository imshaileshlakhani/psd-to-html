<?php
    include("models/connection.php");
    class Admin extends Connection{
        public function __construct(){
            $this->conn = $this->connect();
        }

        public function serviceDetails($data){
            $result = [];
            if(isset($data['userid'])){
                $pageName = trim($data['pageName']);
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;
                $avgRatting = 0.0;

                $total = $this->getTotalServiceByUserId($pageName);
                if(is_null($total) || $total == 0){
                   return [];
                }

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.TotalCost,servicerequest.ServiceProviderId,servicerequest.SubTotal,servicerequest.Status,servicerequest.ServiceStartDate,servicerequestaddress.*,concat(cu.FirstName, ' ', cu.LastName) AS CFullName,concat(sp.FirstName, ' ', sp.LastName) AS SpFullName,sp.UserProfilePicture FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user AS cu ON cu.UserId = servicerequest.UserId LEFT JOIN user AS sp ON sp.UserId = servicerequest.ServiceProviderId LIMIT $offset,$showrecord";

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

        public function userDetails($data){
            $result = [];
            if(isset($data['userid'])){
                $pageName = trim($data['pageName']);
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;

                $total = $this->getTotalServiceByUserId($pageName);
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

        public function getTotalServiceByUserId($pageName = "srequest"){
            $total = 0;
            if($pageName == "srequest"){
                $sql = "SELECT ServiceRequestId FROM servicerequest";
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