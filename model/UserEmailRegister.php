<?php
namespace laptopstore\model;
    /**
     * thông tin giỏ hàng trong session
     */
    class UserEmailRegister {
        public $role_id;
        public $account;
        public $hashedPassword;
        public $created_at;
        public $updated_at;
        
        
        public function __construct($data = null) {
            if ($data !== null) {
                $this->role_id = $data['role_id'];
                $this->account = $data['account'];
                $this->hashedPassword = $data['hashedPassword'];
                $this->created_at = $data['created_at'];
                $this->updated_at = $data['updated_at'];
                
            }
        }
        /**
         * trả về thông tin của session
         */
        public function getInfo(){
            return array(
                'role_id' => $this->role_id,
                'account' => $this->account,
                'hashedPassword' => $this->hashedPassword,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            );
        }
    }
?>