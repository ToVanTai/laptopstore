<?php

include_once __DIR__ . "/../vendor/autoload.php";
/**
 * đối tượng thực hiện gửi mail
 */
class EmailSender {
    private $email;
    private $password;

    public function __construct() {
        $this->email = new PHPMailer\PHPMailer\PHPMailer();
        $this->email->isSMTP();
        $this->email->Host = EMAIL_CONFIG["HOST"];
        $this->email->Port = EMAIL_CONFIG["PORT"];
        $this->email->SMTPSecure = EMAIL_CONFIG["SMTPSecure"];
        $this->email->SMTPAuth = true;
        $this->email->isHTML(true);
        $this->email->Username = EMAIL_CONFIG["FROM_EMAIL"];
        $this->email->Password = EMAIL_CONFIG["FROM_PASSWORD_EMAIL"];
        $this->email->CharSet = 'UTF-8';
        $this->email->Encoding = 'base64';
        $this->email->setFrom(EMAIL_CONFIG["FROM_EMAIL"], EMAIL_CONFIG["Heading"]);
    }
    /**
     * toEmail, tiêu đề, nội dung
     */
    public function sendEmail($options = null,$onSuccess, $onError) {
        try {
            $this->email->addAddress($options['recipientEmail']);
            $this->email->Subject = $options['recipientEmail'];
            $this->email->Body = $options['body'];

            if ($this->email->send()) {
                return $onSuccess();
            } else {
                return $onError();
            }
        } catch (Exception $e) {
            $onError();
        }
    }
}
