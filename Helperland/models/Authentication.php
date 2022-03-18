<?php

    include("models/connection.php");
    class Authentication extends Connection{
        public function __construct(){
            $this->conn = $this->connect();
        }

        public function validate($data){
            if(isset($data['username'])){
                $user = trim($data["username"]);
                $pass = trim($data["password"]);
                $sql = "SELECT UserId,FirstName,LastName,Email,Mobile,DateOfBirth,UserTypeId,IsApproved FROM user WHERE Email='$user' AND Password='$pass'";
            }
            else{
                $email = trim($data["email"]);
                $sql = "SELECT Email FROM user WHERE Email='$email'";
            }
            
            $result = $this->conn->query($sql);
            if($result->num_rows > 0){
                return $result->fetch_assoc();
            }else{
                return [];
            }
        }

        public function is_present($data){
            $email = $data['email'];
            $mobile = $data['phone'];
            $sql = "SELECT Email,Mobile FROM user WHERE Email = '$email' OR Mobile = '$mobile' ";
            $result = $this->conn->query($sql);
            if($result->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        }

        public function insert($data){
            $usertypeid = trim($data["usertypeid"]);
            $fname = trim($data["firstname"]);
            $lname = trim($data["lastname"]);
            $email = trim($data["email"]);
            $pass = trim($data["psw"]);
            $mobile = trim($data["phone"]);
            $avtar = "avatar-hat.png";
            $IsApproved = 0;
            if($usertypeid == 1)
                $IsApproved = 1;

            $sql = "INSERT INTO user (UserTypeId, FirstName, LastName,Email,Mobile,Password,UserProfilePicture,CreatedDate,IsApproved) VALUES ($usertypeid,'$fname','$lname','$email','$mobile','$pass','$avtar',now(),$IsApproved)";
        
            if($this->conn->query($sql) == TRUE){
                return true;
            }else{
                return false;
            }
        }

        public function change_password($data){
            $pass = $data['psw'];
            $cpass = $data['cpsw'];
            $email = $data['email'];
            if($pass == $cpass){
                $sql = "UPDATE user SET Password = '$pass' WHERE Email = '$email' ";

                if($this->conn->query($sql) == TRUE){
                    return true;
                }else{
                    return false;
                }
            }
        }

    }
    
?>
