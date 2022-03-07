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
                if(is_null($total) || $total == 0){
                   return [];
                }

                $sql = "SELECT servicerequest.ServiceRequestId,servicerequest.RecordVersion,servicerequest.ServiceStartDate,servicerequest.TotalCost,servicerequest.SubTotal,servicerequest.ServiceProviderId,servicerequest.HasPets,servicerequest.Status,user.FirstName,user.LastName,user.UserProfilePicture FROM servicerequest LEFT JOIN user ON user.UserId = servicerequest.ServiceProviderId WHERE servicerequest.UserId = $userId AND servicerequest.Status IN (" . implode(',', $status) . ") LIMIT $offset,$showrecord";

                $result = $this->conn->query($sql);
                $rows = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $address = $this->getAddressByServiceId($row['ServiceRequestId']);
                        $extra = $this->getExtraByServiceId($row['ServiceRequestId']);
                        $ratingDone = $this->isRatingDone($row['ServiceRequestId']);
                        $row['ratingDone'] = $ratingDone;
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

        public function isRatingDone($serviceId){
            $ratingDone = false;
            $sql = "SELECT * FROM rating WHERE ServiceRequestId = $serviceId";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $ratingDone = true;
            }
            return $ratingDone;
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
                $email = $this->getSpEmailByServiceId($serviceId);
				$result = true; 
			}
			else{
				$result = false;
			}
            return [$result,$email];
        }

        public function rescheduleService($data,$status,$record_version){
            $serviceId = $data['serviceId'];
            $date = $data['date'];
            $start_time = $data['time'];

            // set date format 
            $date = new DateTime($date);
            $date->setTime(floor($start_time), floor($start_time) == $start_time ? "00" : (("0." . substr($start_time, -1) * 60) * 100));
            $cleaningstartdate = $date->format('Y-m-d H:i:s');

            $result = "";
            $sql = "UPDATE servicerequest SET ServiceStartDate = '$cleaningstartdate', Status = $status, RecordVersion = $record_version WHERE ServiceRequestId = $serviceId";
            if($this->conn->query($sql) == TRUE){
                $email = $this->getSpEmailByServiceId($serviceId);
				$result = true; 
			}
			else{
				$result = false;
			}
            return [$result,$email];
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

        public function show_fav_block_sp($data){
            $result1 = [];
            if(isset($data['userid'])){
                $userId = trim($data['userid']);
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;
                $avgRatting = 0.0;
                $totalService = 0;

                $total = $this->getTotalServicerByUserId($userId);
                if(is_null($total) || $total == 0){
                    return [];
                }

                $sql = "SELECT favoriteandblocked.*,user.FirstName,user.LastName,user.UserProfilePicture FROM favoriteandblocked JOIN user ON user.UserId = favoriteandblocked.TargetUserId WHERE favoriteandblocked.TargetUserId IN (SELECT servicerequest.ServiceProviderId FROM servicerequest WHERE UserId = $userId AND Status = 4) AND favoriteandblocked.UserId = $userId LIMIT $offset,$showrecord";

                $result = $this->conn->query($sql);
                $rows = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['Totalrecord'] = $total;
                        $avgRatting = $this->getRattingBySpId($row['TargetUserId']);
                        $totalService = $this->getTotalServiceBySpId($row['TargetUserId']);
                        $row['totalService'] = $totalService;
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

        public function getTotalServiceBySpId($spid){
            $total = 0;
            $sql = "SELECT ServiceRequestId FROM servicerequest WHERE ServiceProviderId = $spid AND Status = 4";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $total = $result->num_rows;
            }
            else{
                $total = 0;
            }
            return $total;
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

        function settingAddress($data){
            $details = [];
            if(isset($data['userid'])){
                $userId = trim($data['userid']);
                $sql = "SELECT AddressId,AddressLine1,City,State,PostalCode,Email,Mobile FROM useraddress WHERE UserId = $userId AND IsDeleted = 0";
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

        public function add_edit_address($data){
            if(isset($data)){
                $AddressLine1 = trim($data['sstreet'])." ".trim($data['shouse']);
                $zipcode = trim($data['spostal']);
                $city = trim($data['scity']);
                $userId = trim($data['userId']);
                $mnumber = trim($data['smobile']);
                $email = trim($data['email']);
                $addressid = $data['addressid'];

                if($addressid == 0){
                    $sql = "INSERT INTO useraddress (UserId, AddressLine1, City, PostalCode, Mobile, Email) VALUES ($userId,'$AddressLine1','$city','$zipcode','$mnumber','$email')";
                }
                else{
                    $sql = "UPDATE useraddress SET AddressLine1 = '$AddressLine1',City = '$city',PostalCode = '$zipcode',Mobile = '$mnumber' WHERE AddressId = $addressid";
                }
                

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
                        return ['smsg'=>"Password change successfully",'yes'=>true];
                    }
                    else{
                        return ['smsg'=>"Not able to change password please try later",'yes'=>false];
                    }
                }
                else{
                    return ['yes'=>false];
                }
            }
        }

        public function deleteAddress($data){
            $addressId = trim($data['addressId']);
            $userId = trim($data['userId']);
            $sql = "UPDATE useraddress SET IsDeleted = 1 WHERE AddressId = $addressId AND UserId = $userId";
            if($this->conn->query($sql) == TRUE){
                return true;
            }else{
                return false;
            }
        }

        public function saveRatting($data){
            $Ontime = $data['Ontime'];
            $Friendly = $data['Friendly'];
            $Quality = $data['Quality'];
            $ratComment = $data['ratComment'];
            $userId = $data['userId'];
            $spid = $data['spid'];
            $avgRatting = ($Ontime + $Friendly + $Quality)/3;
            $serviceid = $data['serviceid'];

            $sql = "INSERT INTO rating(ServiceRequestId, RatingFrom, RatingTo, Ratings, Comments, RatingDate, OnTimeArrival, Friendly, QualityOfService) VALUES ($serviceid,$userId,$spid,$avgRatting,'$ratComment',now(),$Ontime,$Friendly,$Quality)";

            if($this->conn->query($sql) == TRUE){
                return true;
            }
            else{
                return false;
            }
        }

        public function getAddressById($data){
            if(isset($data['userId'])){
                $details = [];
                $userId = $data['userId'];
                $addressId = $data['addresid'];
                $sql = "SELECT AddressLine1,City,State,PostalCode,Mobile FROM useraddress WHERE UserId = $userId AND AddressId = $addressId";
                $result = $this->conn->query($sql);
                if($result->num_rows > 0){
                    $details = $result->fetch_assoc();
                }
                else{
                    $details = [];
                }
            }
            return $details;
        }

    }
