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

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.ServiceStartDate,servicerequest.TotalCost,servicerequest.SubTotal,servicerequest.ServiceProviderId,servicerequest.HasPets,servicerequest.Status,user.FirstName,user.LastName FROM servicerequest LEFT JOIN user ON user.UserId = servicerequest.ServiceProviderId WHERE servicerequest.UserId = $userId AND servicerequest.Status IN (" . implode(',', $status) . ") LIMIT $offset,$showrecord";

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
            $sql = "SELECT ServiceRequestId FROM servicerequest WHERE UserId = $userId AND servicerequest.Status IN (" . implode(',', $status) . ")";
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

        public function show_fav_block_sp($data){
            $result1 = [];
            if(isset($data['userid'])){
                $userId = trim($data['userid']);
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;
                $avgRatting = 0.0;

                $total = $this->getTotalServicerByUserId($userId);

                $sql = "SELECT DISTINCT servicerequest.ServiceProviderId,user.FirstName,user.LastName,favoriteandblocked.IsFavorite,favoriteandblocked.IsBlocked FROM servicerequest JOIN user on user.UserId = servicerequest.ServiceProviderId JOIN favoriteandblocked ON user.UserId = favoriteandblocked.TargetUserId WHERE servicerequest.UserId = $userId AND servicerequest.Status = 4 LIMIT $offset,$showrecord";

                $result = $this->conn->query($sql);
                $rows = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['Totalrecord'] = $total;
                        $avgRatting = $this->getRattingBySpId($row['ServiceProviderId']);
                        if(is_null($avgRatting['avgrating'])){
                            $avgRatting['avgrating'] = "0.0";
                            $row['avgRatting'] = $avgRatting;
                        }else{
                            $row['avgRatting'] = $avgRatting;
                        }
                        array_push($rows, $row);
                    }
                    $result1 = $rows;
                } else {
                    $result1 = [];
                }
            }
            return $result1; 
        }

        public function getTotalServicerByUserId($userId){
            $total = 0;
            $sql = "SELECT DISTINCT ServiceProviderId FROM servicerequest WHERE UserId = $userId AND Status = 4";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $total = $result->num_rows;
            }
            else{
                $total = 0;
            }
            return $total;
        }

        function fav_block_sp($data){
            $result = "";
            $userId = $data['userId'];
            $spid = $data['servicerId'];
            $action = $data['fbaction'];
            $status = $data['fbstatus'];

            if($status == 1){
                $status = 0;
            }else{
                $status = 1;
            }

            $sql = "UPDATE favoriteandblocked SET $action = $status WHERE UserId = $userId AND TargetUserId = $spid";
            if($this->conn->query($sql) == TRUE){
				$result = true; 
			}
			else{
				$result = false;
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

        function settingAddress($data){
            $details = [];
            if(isset($data['userid'])){
                $userId = trim($data['userid']);
                $sql = "SELECT AddressId,AddressLine1,City,State,PostalCode,Email,Mobile FROM useraddress WHERE UserId = $userId";
                $result = $this->conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        array_push($details, $row);
                    }
                }
                else{
                    $details = [];
                }
            }
            return $details;
        }

        public function add_address($data){
            if(isset($data)){
                $AddressLine1 = trim($data['sstreet'])." ".trim($data['shouse']);
                $zipcode = trim($data['spostal']);
                $city = trim($data['scity']);
                $userId = trim($data['userId']);
                $mnumber = trim($data['smobile']);
                $email = trim($data['email']);

                $sql = "INSERT INTO useraddress (UserId, AddressLine1, City, PostalCode, Mobile, Email) VALUES ($userId,'$AddressLine1','$city','$zipcode','$mnumber','$email')";

                $result = $this->conn->query($sql);
                if($result){
                    return true;
			    }
			    else{
				    return false;
			    }
            }
        }

        public function editSettingDetails($data){
            if(isset($data)){
                $firstname = trim($data['firstname']);
                $lastname = trim($data['lastname']);
                $mobile = trim($data['mobile']);
                $userId = trim($data['userId']);
                $dob = trim($data['dob']);

                $sql = "UPDATE user SET FirstName='$firstname',LastName='$lastname',Mobile='$mobile',DateOfBirth='$dob' WHERE UserId = $userId";

                $result = $this->conn->query($sql);
                if($result){
                    $sql1 = "SELECT UserId,FirstName,LastName,Email,Mobile,DateOfBirth,UserTypeId FROM user WHERE UserId = $userId";
                    $result1 = $this->conn->query($sql1);
                    if($result1->num_rows > 0){
                        return $result1->fetch_assoc();
                    }else{
                        return [];
                    }
			    }
			    else{
				    return [];
			    }
            }
        }

        public function changeOldPassword($data){
            if(isset($data)){
                $userid = trim($data['userid']);
                $oldpsw = trim($data['oldpsw']);
                $newpsw = trim($data['newpsw']);

                $sql = "SELECT Password FROM user WHERE Password = '$oldpsw' AND UserId = $userid";
                $result = $this->conn->query($sql);
                if($result->num_rows > 0){
                    $sql1 = "UPDATE user SET Password = '$newpsw' WHERE UserId = $userid";
                    $result1 = $this->conn->query($sql1);
                    if($result1){
                        return "Password change successfully";
                    }
                    else{
                        return "not able to change password";
                    }
                }
                else{
                    return "Please insert valid old password";
                }
            }
        }

    }
?>