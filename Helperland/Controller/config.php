<?php 
class Config{
    
    /*------------ Database Constant ------------*/
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASS = "";
    const DB_NAME = "helperland";
    
    /*------------ Users Constant--------------*/
    const SESSION_DESTROY_TIME = 60*60*1; // 1 hour (60sec * 60min * 1hour)

    // 1 = customer, 2 = servicer, 3 = admin
    const USER_TYPE = [1,2,3];

    const SMTP_HOST = "smtp.gmail.com";
    const SMTP_EMAIL = "slakhani062@rku.ac.in";
    const SMTP_PASS = "LSNH294@9216";
}
?>