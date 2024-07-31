<?php
namespace App\DTO;
use App\Entity\Projet;

class ProjectDTO implements \JsonSerializable{

    private  $project;
    public function __construct(Projet $project){
        $this->project = $project;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->project->getId(),
            'nom_projet' => $this->project->getNomProjet(),
            'type' => $this->project->getType(),
            'descripition' => $this->project->getDescription(),
            'zone' => $this->project->getZone(),
            'prix'=>$this->project->getPrix(),
            'delais'=>$this->project->getDelais(),
            'status' => $this->project->getStatus(),
            'photo' => $this->project->getPhoto(),
            'type_batiment' => $this->project->getTypebatiment(),
            'user'=> new UserDTO($this->project->getUser())
        );
    }
}