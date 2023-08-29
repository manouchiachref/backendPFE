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
            'name' => $this->user->getName(),
            'username' => $this->user->getUserName(),
            'roles' => $this->user->getRoles(),
            'label' => $this->user->getLabel(),
            'metier' => $this->user->getMetier(),
            'zone' => $this->user->getZone(),
            'matricule_fiscal' => $this->user->getMatriculeFiscal(),
            'solde' => $this->user->getSolde(),
            'status' => $this->user->getStatus()
        );
    }

}