* For security reasons not provide the password so phpmailer is not working if you want to activate the mail system, you have to give password in SMTP_PASS for email SMTP_EMAIL.
* You can change SMTP_ADMIN to send email to admin.
* All above change have to do in config file.

# SMTP configuration (config.php)
* set const SMTP_EMAIL = ""; 
* set const SMTP_PASS = "";
* set const SMTP_ADMIN = ""; (for sending mail to the admin)
