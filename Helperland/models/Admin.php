<?php
    include("models/connection.php");
    class Admin extends Connection{
        public function __construct(){
            $this->conn = $this->connect();
        }

        public function serviceDetails($data){
            $result = [];
            if(isset($data['userid'])){
                // $userId = trim($data['userid']);
                $avgRatting = 0.0;

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.ServiceProviderId,servicerequest.SubTotal,servicerequest.Status,servicerequest.ServiceStartDate,servicerequestaddress.*,concat(cu.FirstName, ' ', cu.LastName) AS CFullName,concat(sp.FirstName, ' ', sp.LastName) AS SpFullName,sp.UserProfilePicture FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user AS cu ON cu.UserId = servicerequest.UserId LEFT JOIN user AS sp ON sp.UserId = servicerequest.ServiceProviderId";

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
                        array_push($rows, $row);
                    }
                    $result = $rows;
                } else {
                    $result = [];
                }
            }
            return $result; 
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