<?php
namespace App\DTO;
use App\Entity\User;

class UserDTO implements \JsonSerializable{

    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }
    
    public function jsonSerialize() {
        return array(
            'id' => $this->user->getId(),                      
            'name' => $this->user->getName(),
            'username' => $this->user->getUserName(),               
            'roles' => $this->user->getRoles(),
            'createdDate' => $this->user->getCreatedDate(),
            'isVerified' => $this->user->isVerified(),
            'status' => $this->user->getStatus()              
        );
    }

}