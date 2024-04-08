<?php
namespace laptopstore\model;
    /**
     * thông tin giỏ hàng trong session
     */
    class TokenInfo {
        /**
         * token để truy cập
         */
        public $AccessToken;

        /**
         * token để làm mới
         */
        public $RefreshToken;
        
        /**
         * role_id
         */
        public $user_id;

        /**
         * role_id
         */
        public $role_id;
        
        public function __construct($data = null) {
            if ($data !== null) {
                $this->AccessToken = isset($data['AccessToken']) ? $data['AccessToken'] : null;
                $this->RefreshToken = isset($data['RefreshToken']) ? $data['RefreshToken'] : null;
                $this->user_id = isset($data['user_id']) ? $data['user_id'] : null;
                $this->role_id = isset($data['role_id']) ? $data['role_id'] : null;
            }else{
                $this->AccessToken = null;
                $this->RefreshToken = null;
                $this->user_id = null;
                $this->role_id = null;
            }
        }
        /**
         * trả về thông tin của session
         */
        public function getTokenInfo(){
            return array(
                'AccessToken' => $this->AccessToken,
                'RefreshToken' => $this->RefreshToken,
                'role_id' => $this->role_id,
                'user_id' => $this->user_id
            );
        }

        /**
         * set thông tin tokenInfo dựa trên Access token
         */
        public function setTokenInfo($decodedToken){
            if(isset($decodedToken->user_id)){
                $this->user_id = $decodedToken->user_id;
            }
            if(isset($decodedToken->role_id)){
                $this->role_id = $decodedToken->role_id;                
            }
        }
    }
?>