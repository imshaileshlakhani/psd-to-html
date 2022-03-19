<?php 
class Config{
    /*------------ Database Constant ------------*/
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASS = "";
    const DB_NAME = "helperland";
    
    /*------------ Users Constant--------------*/

    // 1 = customer, 2 = servicer, 3 = admin
    const USER_TYPE = [1,2,3];

    const SMTP_HOST = "smtp.gmail.com";
    const SMTP_EMAIL = "slakhani062@rku.ac.in";
    
    //Enter password of SMTP_EMAIL to activate email functionality
    const SMTP_PASS = "";
    const SMTP_ADMIN = "shaileshlakhani1234@gmail.com";

    // url constant
    const BASE_URL = "http://localhost/psd-to-html/Helperland/";
}
?>
