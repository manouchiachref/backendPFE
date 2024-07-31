<?php
namespace App\DTO;
use App\Entity\User;

class ProDTO implements \JsonSerializable{

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
            'label' => $this->user->getLabel(),
            'metier' => $this->user->getMetier(),
            'zone' => $this->user->getZone(),
            'isVerified' => $this->user->isVerified(),
            'matricule_fiscal' => $this->user->getMatriculeFiscal(),
            'solde' => $this->user->getSolde(),
            'numtel' => $this->user->getNumtel()
        );
    }

}