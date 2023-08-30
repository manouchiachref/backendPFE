<?php
namespace App\DTO;
use App\Entity\Request;

class RequestDTO implements \JsonSerializable{

    private  $request;
    public function __construct(Request $request){
        $this->request = $request;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->request->getId(),
            'descripition' => $this->request->getDescription(),
            'projet' => new ProjectDTO($this->request->getProject()),
            'status' => $this->request->getStatus(),
            'user'=> new ProDTO($this->request->getPro())
        );
    }
}