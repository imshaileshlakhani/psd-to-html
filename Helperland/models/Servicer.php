<?php
    include("models/connection.php");
    class Servicer extends Connection{
        public function __construct(){
            $this->conn = $this->connect();
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