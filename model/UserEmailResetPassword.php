<?php
namespace laptopstore\model;
    /**
     * thông tin giỏ hàng trong session
     */
    class UserEmailResetPassword {
        public $account;
        public $hashedPassword;
        public $type;
        
        public function __construct($data = null) {
            if ($data !== null) {
                $this->account = $data['account'];
                $this->hashedPassword = $data['hashedPassword'];
                $this->type = $data['type'];
                
            }
        }
        /**
         * trả về thông tin của session
         */
        public function getInfo(){
            return array(
                'account' => $this->account,
                'hashedPassword' => $this->hashedPassword,
                'type' => $this->type
            );
        }
    }
?>