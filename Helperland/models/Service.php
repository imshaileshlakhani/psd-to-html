<?php
include("models/connection.php");
class Service extends Connection
{
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function is_validPostal($data)
    {
        if (isset($data['postal'])) {
            $postal = trim($data['postal']);
            $sql = "SELECT useraddress.PostalCode,useraddress.City,useraddress.State FROM user JOIN useraddress on user.UserId = useraddress.UserId  WHERE user.UserTypeId = 2 and useraddress.PostalCode = '$postal'";

            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return [];
            }
        }
    }

    public function get_address($data)
    {
        $result = [];
        if (isset($data['zipcode'])) {
            $postal = trim($data['zipcode']);
            $userId = trim($data['userdata']);
            $sql = "SELECT * FROM useraddress WHERE UserId = $userId and PostalCode = '$postal' and IsDeleted = 0";
            $result = $this->conn->query($sql);
            $rows = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($rows, $row);
                }
                $result = $rows;
            } else {
                $result = [];
            }
            return $result;
        }
    }

    public function get_favSp($data)
    {
        $result = [];
        if (isset($data['userdata'])) {
            $userId = trim($data['userdata']);
            $pet = trim($data['WorkWithPet']);

            $sql = "SELECT fb.*, user.UserProfilePicture, concat(user.FirstName, ' ', user.LastName) AS FullName FROM favoriteandblocked AS fb JOIN user ON user.UserId = fb.TargetUserId WHERE fb.UserId = $userId AND fb.TargetUserId IN (SELECT UserId FROM favoriteandblocked WHERE TargetUserId = $userId AND IsBlocked=0) AND user.IsApproved = 1 AND user.IsDeleted = 0 AND fb.IsFavorite = 1 AND fb.IsBlocked = 0 AND user.WorksWithPets >= 0";

            $result = $this->conn->query($sql);
            $rows = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($rows, $row);
                }
                $result = $rows;
            } else {
                $result = [];
            }
        }
        return $result;
    }

    public function add_address($data)
    {
        if (isset($data)) {
            $AddressLine1 = trim($data['sname']);
            $AddressLine2 = trim($data['hnumber']);
            $zipcode = trim($data['zipcode']);
            $city = trim($data['cname']);
            $userId = trim($data['userdata']);
            $mnumber = trim($data['mnumber']);
            $state = trim($data['statename']);
            $email = trim($data['email']);

            $sql = "INSERT INTO useraddress (UserId, AddressLine1, AddressLine2, City, State, PostalCode, Mobile, Email) VALUES ($userId,'$AddressLine1','$AddressLine2','$city','$state','$zipcode','$mnumber','$email')";

            $result = $this->conn->query($sql);
            if ($result) {
                $address = $this->get_address($data);
                return $address;
            } else {
                return [];
            }
        }
    }

    public function add_serviceAddress($serviceId, $addressId)
    {
        $sql = "INSERT INTO servicerequestaddress (ServiceRequestId, AddressLine1, AddressLine2, City, State, PostalCode, Mobile, Email) SELECT $serviceId,AddressLine1, AddressLine2, City, State, PostalCode, Mobile, Email FROM useraddress WHERE AddressId = $addressId";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function add_extraService($serviceId, $ExtraServiceId)
    {
        $sql = "INSERT INTO servicerequestextra (ServiceRequestId,ServiceExtraId) VALUES ($serviceId,$ExtraServiceId)";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function get_servicerEmail($ServiceProviderId, $postalcode, $HasPet)
    {
        $email = [];
        if ($ServiceProviderId != 'null') {
            $sql = "SELECT Email FROM user WHERE UserId = $ServiceProviderId";
        } else {
            $sql = "SELECT user.Email FROM user LEFT JOIN useraddress ON user.UserId = useraddress.UserId WHERE user.UserTypeId = 2 AND useraddress.PostalCode = '$postalcode'";
        }
        $result = $this->conn->query($sql);

        $rows = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row['Email']);
            }
            $email = $rows;
        } else {
            $email = [];
        }
        return $email;
    }

    public function book_service($data)
    {
        if (isset($data)) {
            $email = [];
            $last_id = 0;
            $time = $data['time'];
            $AddressId = $data['address'];
            $userid = $data['userId'];
            $ServiceStartDate = $data['date'];
            $postalcode = $data['postal'];
            $SubTotal = $data['totalhr'] * 18;
            $ServiceHourlyRate = 18;
            $discount = 0;
            $TotalCost = $SubTotal - $discount;
            $Comments = $data['comment'];
            $ExtraHours = 0;

            $SPAcceptedDate = 'null';
            $Status = 0;
            $PaymentDone = 1;
            $ServiceProviderId = 'null';
            $HasPets = 0;
            $ExtraServiceId = 0;

            // set date format 
            $date = new DateTime($ServiceStartDate);
            $date->setTime(floor($time), floor($time) == $time ? "00" : (("0." . substr($time, -1) * 60) * 100));
            $cleaningstartdate = $date->format('Y-m-d H:i:s');

            if (isset($data['extra'])) {
                $ExtraServiceId = implode("", $data['extra']);
                $ExtraHours = count($data['extra']) * 0.5;
            }
            if (isset($data['favsp'])) {
                $ServiceProviderId = $data['favsp'];
            }
            if ($ServiceProviderId == 'null') {
                $Status = 0;
            } else {
                $Status = 1;
            }
            if (isset($data['pet'])) {
                $HasPets = $data['pet'];
            }
            $ServiceHours = $data['totalhr'];

            $sql = "INSERT INTO servicerequest (UserId, ServiceStartDate, ZipCode, ServiceHourlyRate, ServiceHours, ExtraHours, SubTotal, Discount, TotalCost, Comments, ServiceProviderId, SPAcceptedDate, HasPets, Status, CreatedDate, PaymentDone) 
                VALUES ($userid, '$cleaningstartdate', '$postalcode', $ServiceHourlyRate, $ServiceHours, $ExtraHours, $SubTotal, $discount, $TotalCost, '$Comments', $ServiceProviderId, $SPAcceptedDate, $HasPets, $Status, now(), $PaymentDone);";

            $result = $this->conn->query($sql);
            if ($result) {
                $last_id = $this->conn->insert_id;
                $address = $this->add_serviceAddress($last_id, $AddressId);
                if ($address) {
                    $extraService = $this->add_extraService($last_id, $ExtraServiceId);
                    if ($extraService) {
                        $email = $this->get_servicerEmail($ServiceProviderId, $postalcode, $HasPets);
                    }
                }
            }
            return [$last_id, $email];
        }
    }

    public function getServiceRequestById($serviceid)
    {
        $sql = "SELECT * FROM servicerequest JOIN servicerequestaddress ON servicerequestaddress.ServiceRequestId = servicerequest.ServiceRequestId WHERE servicerequest.ServiceRequestId = $serviceid";
        $service = $this->conn->query($sql);
        if ($service->num_rows > 0) {
            $result = $service->fetch_assoc();
        } else {
            $result = [];
        }
        return $result;
    }

    public function getUserAddressById($addressid)
    {
        $sql = "SELECT * FROM useraddress WHERE AddressId=$addressid AND IsDeleted=0";
        $result = $this->conn->query($sql);
        if ($result->num_rows < 1) {
            $result = [];
        } else {
            $result = $result->fetch_assoc();
        }
        return $result;
    }

    public function isServiceAvailable($addressid, $ondate, $userid)
    {
        $address = $this->getUserAddressById($addressid);
        if (count($address) < 1) {
            $result = false;
            // echo "1";
        } else {
            $addline1 = $address["AddressLine1"];
            $addline2 = $address["AddressLine2"];
            $city = $address["City"];
            $state = $address["State"];
            $postalcode = $address["PostalCode"];
            $sql = "SELECT DATE_FORMAT(servicerequest.ServiceStartDate, '%Y-%m-%d') as ServiceStartDate, servicerequest.Status FROM servicerequest JOIN servicerequestaddress ON servicerequestaddress.ServiceRequestId = servicerequest.ServiceRequestId WHERE servicerequest.UserId = $userid AND servicerequestaddress.AddressLine1='$addline1' AND servicerequestaddress.AddressLine2='$addline2' AND servicerequestaddress.City='$city' AND servicerequestaddress.State='$state' AND servicerequestaddress.PostalCode = '$postalcode' AND DATE_FORMAT(servicerequest.ServiceStartDate, '%Y-%m-%d') = '$ondate'";
            // echo $sql;
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $result = $result->fetch_assoc();
                if ($result["Status"] != 5 && $result["ServiceStartDate"] == $ondate) {
                    $result = false;
                    // echo "2";
                }
            }
            else{
                $result = true;
                // echo "3";
            }
        }
        return $result;
    }
}
