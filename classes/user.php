<?php
class User
{
    public $role_id;
    public $account;
    public $password;
    public $name;
    public $phone_number;
    public $address;
    public $avatar;
    public $email;
    public $created_at;
    public $updated_at;
    public function __construct(
        $role_id,
        $account,
        $password,
        $name,
        $phone_number,
        $address,
        $avatar,
        $email,
        $created_at,
        $updated_at
    ) {
        $this->role_id = $role_id;
        $this->account =    $account;
        $this->password =    $password;
        $this->name =    $name;
        $this->phone_number =    $phone_number;
        $this->address =    $address;
        $this->avatar =    $avatar;
        $this->email =    $email;
        $this->created_at =    $created_at;
        $this->updated_at =    $updated_at;
    }
    public static function createUser($role_id,$account,$password){
        //
    }
}
?>
//create read update