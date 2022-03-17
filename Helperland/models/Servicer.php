<?php
include("models/connection.php");
class Servicer extends Connection
{
    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function serviceDetails($data)
    {
        $result = [];
        if (isset($data['userid'])) {
            $userId = trim($data['userid']);
            $showrecord = trim($data['limit']);
            $offset = ($data['page'] - 1) * $showrecord;
            $status = $data['status'];
            $pageName = $data['pageName'];
            $withpet = $data['withpet'];

            $total = $this->getTotalRecordByUserId($pageName, $userId, $status, 0, 1, $withpet);
            if (is_null($total) || $total == 0) {
                return [];
            }

            if ($pageName == "New") {
                $sql = "SELECT servicerequest.*,servicerequestaddress.*,user.FirstName,user.LastName FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user ON servicerequest.UserId = user.UserId LEFT JOIN favoriteandblocked AS f1 ON f1.UserId = servicerequest.UserId LEFT JOIN favoriteandblocked AS f2 ON f2.TargetUserId = servicerequest.UserId WHERE ((f2.UserId = $userId AND f1.TargetUserId=$userId AND f1.IsBlocked = 0 AND f2.IsBlocked = 0) OR (f1.TargetUserId IS NULL) OR
                f1.TargetUserId IN (SELECT UserId FROM user WHERE UserTypeId = 2 AND IsApproved=1 )) AND servicerequest.Status IN (" . implode(',', $status) . ") AND (servicerequest.ServiceProviderId = $userId OR servicerequest.ServiceProviderId IS NULL) AND servicerequest.HasPets <= $withpet GROUP BY servicerequest.ServiceRequestId LIMIT $offset,$showrecord";
            } else {
                $sql = "SELECT servicerequest.*,servicerequestaddress.*,user.FirstName,user.LastName FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user ON servicerequest.UserId = user.UserId WHERE servicerequest.Status IN (" . implode(',', $status) . ") AND (servicerequest.ServiceProviderId = $userId OR servicerequest.ServiceProviderId IS NULL) LIMIT $offset,$showrecord";
            }

            // echo $sql;

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

    public function getServiceByMonthAndYear($spid, $startdate, $status)
    {
        $startdate = date("Y-m", strtotime($startdate));
        $sql = "SELECT sr.ServiceRequestId, DATE_FORMAT(sr.ServiceStartDate, '%H:%i') as ServiceStartTime,DATE_FORMAT(sr.ServiceStartDate, '%Y-%m-%d') as StartDate, sr.ServiceStartDate, sr.UserId, sr.ServiceHourlyRate,sr.ServiceHours,sr.ExtraHours, sr.SubTotal, sr.Discount,sr.TotalCost, sr.ServiceProviderId, sr.SPAcceptedDate, sr.HasPets, sr.Status,sr.HasIssue, sr.PaymentDone, sr.RecordVersion, sr.ModifiedBy, sr.ModifiedDate, sr.Comments, sra.AddressLine1, sra.AddressLine2, sra.City, sra.State, sra.PostalCode, sra.Mobile, sre.ServiceExtraId, user.FirstName, user.LastName, user.Email FROM servicerequest AS sr JOIN user ON user.UserId = sr.UserId JOIN servicerequestaddress AS sra ON sra.ServiceRequestId = sr.ServiceRequestId LEFT JOIN servicerequestextra AS sre ON sre.ServiceRequestId = sr.ServiceRequestId WHERE sr.ServiceProviderId = $spid AND sr.Status IN $status AND sr.ServiceStartDate LIKE '%$startdate%';";
        $services = $this->conn->query($sql);
        $rows = [];
        //echo $sql;
        if ($services->num_rows > 0) {
            // check any slot time with selected time
            while ($row = $services->fetch_assoc()) {
                array_push($rows, $row);
            }
        }
        return $rows;
    }

    public function getTotalRecordByUserId($pageName, $userId, $status, $ratingS = 0, $ratingE = 1, $withpet = 0)
    {
        $total = 0;
        if ($pageName == "New") {
            $sql = "SELECT servicerequest.*,servicerequestaddress.*,user.FirstName,user.LastName FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user ON servicerequest.UserId = user.UserId LEFT JOIN favoriteandblocked AS f1 ON f1.UserId = servicerequest.UserId LEFT JOIN favoriteandblocked AS f2 ON f2.TargetUserId = servicerequest.UserId WHERE ((f2.UserId = $userId AND f1.TargetUserId=$userId AND f1.IsBlocked = 0 AND f2.IsBlocked = 0) OR (f1.TargetUserId IS NULL) OR f1.TargetUserId IN (SELECT UserId FROM user WHERE UserTypeId = 2 AND IsApproved=1 )) AND servicerequest.Status IN (" . implode(',', $status) . ") AND (servicerequest.ServiceProviderId = $userId OR servicerequest.ServiceProviderId IS NULL) AND servicerequest.HasPets <= $withpet GROUP BY servicerequest.ServiceRequestId";
        } else if ($pageName == "Upcoming" || $pageName == "History") {
            $sql = "SELECT ServiceRequestId FROM servicerequest WHERE (ServiceProviderId = $userId OR ServiceProviderId IS NULL) AND Status IN (" . implode(',', $status) . ")";
        } else if ($pageName == "Ratings") {
            $sql = "SELECT rating.*,servicerequest.ServiceStartDate,servicerequest.SubTotal,user.FirstName,user.LastName FROM rating JOIN servicerequest ON rating.ServiceRequestId = servicerequest.ServiceRequestId JOIN user ON user.UserId = rating.RatingFrom WHERE rating.RatingTo = $userId AND (rating.Ratings >= $ratingS AND rating.Ratings <= $ratingE)";
        } else if ($pageName == "Block") {
            $sql = "SELECT favoriteandblocked.*,user.FirstName,user.LastName,user.UserProfilePicture FROM favoriteandblocked JOIN user ON favoriteandblocked.TargetUserId = user.UserId WHERE favoriteandblocked.UserId = $userId";
        }
        // echo $sql;

        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $total = $result->num_rows;
        } else {
            $total = 0;
        }
        return $total;
    }

    public function serviceDetailsByServiceId($data)
    {
        $detail = [];
        if (isset($data['userid'])) {
            $userId = $data['userid'];
            $serviceId = $data['serviceId'];

            $sql = "SELECT servicerequest.*,servicerequestaddress.*,user.FirstName,user.LastName,servicerequestextra.* FROM servicerequest JOIN servicerequestaddress ON servicerequest.ServiceRequestId = servicerequestaddress.ServiceRequestId JOIN user ON servicerequest.UserId = user.UserId JOIN servicerequestextra ON servicerequestextra.ServiceRequestId = servicerequest.ServiceRequestId WHERE servicerequest.ServiceRequestId = $serviceId";

            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $detail = $result->fetch_assoc();
            } else {
                $detail = [];
            }
        }
        return $detail;
    }

    public function getServiceBySpId($userId, $startdate)
    {
        $sql = "SELECT *,DATE_FORMAT(ServiceStartDate,'%H:%i') as ServiceStartTime FROM servicerequest WHERE Status = 2 AND ServiceProviderId = $userId AND ServiceStartDate LIKE '%$startdate%'";
        $result = $this->conn->query($sql);
        $rows = array();
        // echo $sql;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
            return $rows;
        } else {
            return [];
        }
    }

    public function cancleService($data)
    {
        $serviceId = $data['serviceId'];
        $result = "";
        $sql = "UPDATE servicerequest SET Status = 3 WHERE ServiceRequestId = $serviceId";
        if ($this->conn->query($sql) == TRUE) {
            // $email = $this->getSpEmailByServiceId($serviceId);
            $result = true;
        } else {
            $result = false;
        }
        // return [$result,$email];
        return $result;
    }

    public function getRatingsBySpId($data)
    {
        $rating = [];
        if (isset($data['userid'])) {
            $userId = $data['userid'];
            $showrecord = trim($data['limit']);
            $offset = ($data['page'] - 1) * $showrecord;
            $status = 0;
            $pageName = $data['pageName'];
            $ratingS = $data['ratingS'];
            $ratingE = $data['ratingE'];

            $total = $this->getTotalRecordByUserId($pageName, $userId, $status, $ratingS, $ratingE, 0);
            if (is_null($total) || $total == 0) {
                return [];
            }

            $sql = "SELECT rating.*,servicerequest.ServiceStartDate,servicerequest.SubTotal,user.FirstName,user.LastName FROM rating JOIN servicerequest ON rating.ServiceRequestId = servicerequest.ServiceRequestId JOIN user ON user.UserId = rating.RatingFrom WHERE rating.RatingTo = $userId AND (rating.Ratings >= $ratingS AND rating.Ratings <= $ratingE) LIMIT $offset,$showrecord";

            $result = $this->conn->query($sql);
            $rows = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row['Totalrecord'] = $total;
                    array_push($rows, $row);
                }
                $rating = $rows;
            } else {
                $rating = [];
            }
        }
        return $rating;
    }

    public function show_block_user($data)
    {
        $result1 = [];
        if (isset($data['userid'])) {
            $userId = trim($data['userid']);
            $showrecord = trim($data['limit']);
            $offset = ($data['page'] - 1) * $showrecord;
            $status = 0;
            $pageName = $data['pageName'];

            $total = $this->getTotalRecordByUserId($pageName, $userId, $status);
            if (is_null($total) || $total == 0) {
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

    public function setAvtar($data)
    {
        $avtarImg = "";
        $userid = $data['userid'];
        $avtar = $data['avtarName'];
        $sql = "UPDATE user SET UserProfilePicture = '$avtar' WHERE UserId = $userid";
        $result = $this->conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getAddressById($data)
    {
        $userid = $data['userid'];
        $sql = "SELECT useraddress.*,user.UserProfilePicture,user.Gender FROM useraddress JOIN user ON user.UserId = useraddress.UserId WHERE useraddress.UserId = $userid";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return [];
        }
    }

    public function completeService($data)
    {
        $serviceId = $data['serviceId'];
        $customerId = $data['customerId'];
        $userid = $data['userid'];
        $result = "";
        $sql = "UPDATE servicerequest SET Status = 4 WHERE ServiceRequestId = $serviceId";

        $sql1 = "INSERT INTO favoriteandblocked(UserId, TargetUserId, IsFavorite, IsBlocked) VALUES ($customerId,$userid,0,0),($userid,$customerId,0,0)";
        $isPresent = $this->isFavBlock($userid, $customerId);
        if (!$isPresent) {
            $result1 = $this->conn->query($sql1);
        }

        $result = $this->conn->query($sql);
        if ($result) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function isFavBlock($userid, $customerId)
    {
        $sql = "SELECT * FROM favoriteandblocked WHERE UserId = $userid AND TargetUserId = $customerId";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function acceptService($data)
    {
        $serviceId = $data['serviceId'];
        $userid = $data['userid'];

        $sql = "UPDATE servicerequest SET Status = 2,ServiceProviderId = $userid WHERE ServiceRequestId = $serviceId";

        $result = $this->isAccepted($serviceId);
        if (!$result) {
            if ($this->conn->query($sql) == TRUE) {
                return [true, 'Service request has been accepted successfully'];
            } else {
                return [false, 'Not able to accept service'];
            }
        }
        return [false, 'This service request is no more available. It has been assigned to another provider.'];
    }

    public function isAccepted($serviceId)
    {
        $sql = "SELECT * FROM servicerequest WHERE Status = 2 AND ServiceRequestId = $serviceId";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function editSettingDetails($data)
    {
        if (isset($data)) {
            $firstname = trim($data['firstname']);
            $lastname = trim($data['lastname']);
            $mobile = trim($data['mobile']);
            $userId = trim($data['userId']);
            $dob = trim($data['dob']);
            $addressline = trim($data['Streetname']) . ' ' . trim($data['Housenumber']);
            $city = trim($data['city']);
            $postal = trim($data['Postalcode']);
            $email = trim($data['email']);
            $gender = $data['Gender'];

            $sql = "UPDATE user SET FirstName='$firstname',LastName='$lastname',Mobile='$mobile',DateOfBirth='$dob',Gender=$gender,ModifiedDate=now() WHERE UserId = $userId";

            $sql1 = "INSERT INTO useraddress (UserId, AddressLine1, City, PostalCode, Mobile, Email) VALUES ($userId,'$addressline','$city','$postal','$mobile','$email')";
            $address = $this->checkAddressByUserId($userId);
            if ($address) {
                $sql1 = "UPDATE useraddress SET AddressLine1 = '$addressline',City = '$city',PostalCode = '$postal',Mobile = '$mobile',Email = '$email' WHERE UserId = $userId";
            }

            $result = $this->conn->query($sql);
            $result1 = $this->conn->query($sql1);
            if ($result && $result1) {
                $sql2 = "SELECT UserId,FirstName,LastName,Email,Mobile,DateOfBirth,UserTypeId FROM user WHERE UserId = $userId";
                $result2 = $this->conn->query($sql2);
                if ($result2->num_rows > 0) {
                    return $result2->fetch_assoc();
                } else {
                    return [];
                }
            } else {
                return [];
            }
        }
    }

    public function checkAddressByUserId($userId)
    {
        $sql = "SELECT * FROM useraddress WHERE UserId = $userId";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    function blockCustomer($data)
    {
        $result = "";
        $userId = $data['userId'];
        $cId = $data['customerId'];
        $status = $data['fbstatus'];

        if ($status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $sql = "UPDATE favoriteandblocked SET IsBlocked = $status WHERE UserId = $userId AND TargetUserId = $cId";
        if ($this->conn->query($sql) == TRUE) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function changeOldPassword($data)
    {
        if (isset($data)) {
            $userid = trim($data['userid']);
            $oldpsw = trim($data['oldpsw']);
            $newpsw = trim($data['newpsw']);

            $sql = "SELECT Password FROM user WHERE Password = '$oldpsw' AND UserId = $userid";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $sql1 = "UPDATE user SET Password = '$newpsw' WHERE UserId = $userid";
                $result1 = $this->conn->query($sql1);
                if ($result1) {
                    return ['smsg' => "Password change successfully", 'yes' => true];
                } else {
                    return ['smsg' => "Not able to change password please try later", 'yes' => false];
                }
            } else {
                return ['yes' => false];
            }
        }
    }
}
