<?php
    include("models/connection.php");
    class Servicer extends Connection{
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
                $pageName = $data['pageName'];

                $total = $this->getTotalRecordByUserId($pageName,$userId,$status);
                if(is_null($total) || $total == 0){
                   return [];
                }

                $sql = "SELECT servicerequest.*,servicerequestaddress.*,user.FirstName,user.LastName FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user ON servicerequest.UserId = user.UserId WHERE servicerequest.Status IN (" . implode(',', $status) . ") AND (servicerequest.ServiceProviderId = $userId OR servicerequest.ServiceProviderId IS NULL) LIMIT $offset,$showrecord";

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

        public function getTotalRecordByUserId($pageName,$userId,$status){
            $total = 0;
            if($pageName == "New" || $pageName == "Upcoming" || $pageName == "History"){
                $sql = "SELECT ServiceRequestId FROM servicerequest WHERE (ServiceProviderId = $userId OR ServiceProviderId IS NULL) AND Status IN (" . implode(',', $status) . ")";
            }
            else if($pageName == "Ratings"){
                $sql = "SELECT rating.*,servicerequest.ServiceStartDate,servicerequest.SubTotal,user.FirstName,user.LastName FROM rating JOIN servicerequest ON rating.ServiceRequestId = servicerequest.ServiceRequestId JOIN user ON user.UserId = rating.RatingFrom WHERE rating.RatingTo = $userId";
            }
            else if($pageName == "Block"){
                $sql = "SELECT favoriteandblocked.*,user.FirstName,user.LastName,user.UserProfilePicture FROM favoriteandblocked JOIN user ON favoriteandblocked.TargetUserId = user.UserId WHERE favoriteandblocked.UserId = $userId";
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

        public function serviceDetailsByServiceId($data){
            $detail = [];
            if(isset($data['userid'])){
                $userId = $data['userid'];
                $serviceId = $data['serviceId'];

                $sql = "SELECT servicerequest.*,servicerequestaddress.*,user.FirstName,user.LastName,servicerequestextra.* FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user ON servicerequest.UserId = user.UserId JOIN servicerequestextra ON servicerequestextra.ServiceRequestId = servicerequest.ServiceRequestId WHERE (servicerequest.ServiceProviderId = $userId OR servicerequest.ServiceProviderId IS NULL) AND servicerequest.ServiceRequestId = $serviceId";

                $result = $this->conn->query($sql);
                if($result->num_rows > 0){
                    $detail = $result->fetch_assoc();
                }
                else {
                    $detail = [];
                }
            }
            return $detail;
        }

        public function cancleService($data){
            $serviceId = $data['serviceId'];
            $result = "";
            $sql = "UPDATE servicerequest SET Status = 3 WHERE ServiceRequestId = $serviceId";
            if($this->conn->query($sql) == TRUE){
                // $email = $this->getSpEmailByServiceId($serviceId);
				$result = true; 
			}
			else{
				$result = false;
			}
            // return [$result,$email];
            return $result;
        }

        public function getRatingsBySpId($data){
            $rating = [];
            if(isset($data['userid'])){
                $userId = $data['userid'];
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;
                $status = 0;
                $pageName = $data['pageName'];

                $total = $this->getTotalRecordByUserId($pageName,$userId,$status);
                if(is_null($total) || $total == 0){
                   return [];
                }

                $sql = "SELECT rating.*,servicerequest.ServiceStartDate,servicerequest.SubTotal,user.FirstName,user.LastName FROM rating JOIN servicerequest ON rating.ServiceRequestId = servicerequest.ServiceRequestId JOIN user ON user.UserId = rating.RatingFrom WHERE rating.RatingTo = $userId LIMIT $offset,$showrecord";

                $result = $this->conn->query($sql);
                $rows = array();
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $row['Totalrecord'] = $total;
                        array_push($rows, $row);
                    }
                    $rating = $rows;
                }
                else {
                    $rating = [];
                }
            }
            return $rating;
        }

        public function show_block_user($data){
            $result1 = [];
            if(isset($data['userid'])){
                $userId = trim($data['userid']);
                $showrecord = trim($data['limit']);
                $offset = ($data['page'] - 1) * $showrecord;
                $status = 0;
                $pageName = $data['pageName'];

                $total = $this->getTotalRecordByUserId($pageName,$userId,$status);
                if(is_null($total) || $total == 0){
                    return [];
                }

                $sql = "SELECT favoriteandblocked.*,user.FirstName,user.LastName,user.UserProfilePicture FROM favoriteandblocked JOIN user ON favoriteandblocked.TargetUserId = user.UserId WHERE favoriteandblocked.UserId = $userId LIMIT $offset,$showrecord";

                $result = $this->conn->query($sql);
                $rows = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['Totalrecord'] = $total;
                        array_push($rows, $row);
                    }
                    $result1 = $rows;
                } else {
                    $result1 = [];
                }
            }
            return $result1; 
        }

        public function setAvtar($data){
            $avtarImg = "";
            $userid = $data['userid'];
            $avtar = $data['avtarName'];
            $sql = "UPDATE user SET UserProfilePicture = '$avtar' WHERE UserId = $userid";
            $result = $this->conn->query($sql);
            if($result){
                return true;
            }
            else{
                return false;
            }
        }

        public function getAddressById($data){
            $userid = $data['userid'];
            $sql = "SELECT useraddress.*,user.UserProfilePicture,user.Gender FROM useraddress JOIN user ON user.UserId = useraddress.UserId WHERE useraddress.UserId = $userid";
            $result = $this->conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                return $row;
            }
            else{
                return [];
            }
        }

        public function editSettingDetails($data){
            if(isset($data)){
                $firstname = trim($data['firstname']);
                $lastname = trim($data['lastname']);
                $mobile = trim($data['mobile']);
                $userId = trim($data['userId']);
                $dob = trim($data['dob']);
                $addressline = trim($data['Streetname']).' '.trim($data['Housenumber']);
                $city = trim($data['city']);
                $postal = trim($data['Postalcode']);
                $email = trim($data['email']);
                $gender = $data['Gender'];

                $sql = "UPDATE user SET FirstName='$firstname',LastName='$lastname',Mobile='$mobile',DateOfBirth='$dob',Gender=$gender WHERE UserId = $userId";

                $sql1 = "INSERT INTO useraddress (UserId, AddressLine1, City, PostalCode, Mobile, Email) VALUES ($userId,'$addressline','$city','$postal','$mobile','$email')";
                $address = $this->checkAddressByUserId($userId); 
                if($address){
                    $sql1 = "UPDATE useraddress SET AddressLine1 = '$addressline',City = '$city',PostalCode = '$postal',Mobile = '$mobile',Email = '$email' WHERE UserId = $userId";
                }

                $result = $this->conn->query($sql);
                $result1 = $this->conn->query($sql1);
                if($result && $result1){
                    $sql2 = "SELECT UserId,FirstName,LastName,Email,Mobile,DateOfBirth,UserTypeId FROM user WHERE UserId = $userId";
                    $result2 = $this->conn->query($sql2);
                    if($result2->num_rows > 0){
                        return $result2->fetch_assoc();
                    }else{
                        return [];
                    }
			    }
			    else{
				    return [];
			    }
            }
        }

        public function checkAddressByUserId($userId){
            $sql = "SELECT * FROM useraddress WHERE UserId = $userId";
            $result = $this->conn->query($sql);
            if($result->num_rows > 0){
                return true;
            }
            return false;
        }

        function blockCustomer($data){
            $result = "";
            $userId = $data['userId'];
            $cId = $data['customerId'];
            $status = $data['fbstatus'];

            if($status == 1){
                $status = 0;
            }else{
                $status = 1;
            }

            $sql = "UPDATE favoriteandblocked SET IsBlocked = $status WHERE UserId = $userId AND TargetUserId = $cId";
            if($this->conn->query($sql) == TRUE){
				$result = true; 
			}
			else{
				$result = false;
			}
            return $result;
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
    }
?>