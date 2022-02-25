<?php
    include("models/connection.php");
    class Customer extends Connection{
        public function __construct(){
            $this->conn = $this->connect();
        }

        public function serviceDetails($data){
            $result = [];
            if(isset($data['userid'])){
                $userId = trim($data['userid']);
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;
                $status = $data['status'];
                $address = "";
                $extra = "";
                $avgRatting = 0.0;

                $total = $this->getTotalServiceByUserId($userId,$status);

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.ServiceStartDate,servicerequest.TotalCost,servicerequest.SubTotal,servicerequest.ServiceProviderId,servicerequest.HasPets,servicerequest.Status,user.FirstName,user.LastName FROM servicerequest LEFT JOIN user ON user.UserId = servicerequest.ServiceProviderId WHERE servicerequest.UserId = $userId AND (servicerequest.Status = $status[0] OR servicerequest.Status = $status[1]) LIMIT $offset,$showrecord";

                $result = $this->conn->query($sql);
                $rows = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $address = $this->getAddressByServiceId($row['ServiceRequestId']);
                        $extra = $this->getExtraByServiceId($row['ServiceRequestId']);
                        $row['Address'] = $address[0];
                        $row['Mobile'] = $address[1];
                        $row['Email'] = $address[2];
                        $row['extra'] = $extra;
                        $row['Totalrecord'] = $total;
                        if($row['ServiceProviderId'] != null){
                            $avgRatting = $this->getRattingBySpId($row['ServiceProviderId']);
                            $row['avgRatting'] = $avgRatting;
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
            $ratting = 0;
            $counter = 0;
            $avgRatting = 0;
            $sql = "SELECT Ratings FROM rating WHERE RatingTo = $spid";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ratting += $row['Ratings'];
                    $counter++;
                }
                $avgRatting = $ratting/$counter;
            }
            return $avgRatting;
        }

        public function getAddressByServiceId($serviceId){
            $serviceAddress = "";
            $mobile = "";
            $email = "";
            $sql = "SELECT * FROM servicerequestaddress WHERE ServiceRequestId = $serviceId";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $serviceAddress = $row['AddressLine1'].",".$row['PostalCode']." ".$row['City'];
                $mobile = $row['Mobile'];
                $email = $row['Email'];
            }
            return [$serviceAddress,$mobile,$email];
        }

        public function getExtraByServiceId($serviceId){
            $extra = "";
            $sql = "SELECT * FROM servicerequestextra WHERE ServiceRequestId = $serviceId";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $extra = $row['ServiceExtraId'];
            }
            return $extra;
        }

        public function getTotalServiceByUserId($userId,$status){
            $total = 0;
            $sql = "SELECT ServiceRequestId FROM servicerequest WHERE UserId = $userId AND (Status = $status[0] OR Status = $status[1])";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $total = $result->num_rows;
            }
            else{
                $total = 0;
            }
            return $total;
        }

        public function cancleService($data){
            $serviceId = $data['serviceId'];
            $result = "";
            $sql = "UPDATE servicerequest SET Status = 3 WHERE ServiceRequestId = $serviceId";
            if($this->conn->query($sql) == TRUE){
				$result = true; 
			}
			else{
				$result = false;
			}
            return $result;
        }

        public function rescheduleService($data){
            $serviceId = $data['serviceId'];
            $date = $data['date'];
            $time = $data['time'];

            // set date format 
            $date = new DateTime($date);
            $date->setTime(floor($time), floor($time) == $time ? "00" : (("0." . substr($time, -1) * 60) * 100));
            $cleaningstartdate = $date->format('Y-m-d H:i:s');

            $result = "";
            $sql = "UPDATE servicerequest SET ServiceStartDate = '$cleaningstartdate' WHERE ServiceRequestId = $serviceId";
            if($this->conn->query($sql) == TRUE){
				$result = true; 
			}
			else{
				$result = false;
			}
            return $result;
        }
    }
?>