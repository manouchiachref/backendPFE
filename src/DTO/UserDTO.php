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
            'firstname' => $this->user->getFirstname(),
            'lastname' => $this->user->getLastname(),
            'username' => $this->user->getUserName(),
            'roles' => $this->user->getRoles(),
            'isVerified' => $this->user->isVerified(),
            'numtel'=>$this->user->getNumtel(),
            'zone'=>$this->user->getZone(),

        );
    }

}