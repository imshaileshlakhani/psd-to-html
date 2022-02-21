<?php
    class CustomerController{
        public function __construct(){
            
        }

        public function customerDashboard($parameter=""){
            include('View/Customer/Customer-Dashboard.php');
        }
    }
?>