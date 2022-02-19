For security resion not provide the password so phpmailer is not working if you want to activate mail system you have to give password in SMTP_PASS for email SMTP_EMAIL
you can change SMTP_ADMIN to send email to admin
all above change have to do in config file

SMTP configuration (config.php)
set const SMTP_EMAIL = ""; 
set const SMTP_PASS = "";
