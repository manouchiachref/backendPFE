<?php

namespace App\Controller;

use App\DTO\ProDTO;
use App\DTO\ProjectDTO;
use App\DTO\UserDTO;
use App\Entity\User;
use App\Form\ProType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/pro")
 */
class ProController extends AbstractApiController
{
    /**
     * @Route("/", name="Pro_index", methods={"GET"})
     */
    public function index(): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $usersList = $userRepository->findUsersByRoles(['ROLE_PRO']);
        $users= $userRepository->Pros($usersList);
        return $this->respond($users);
    }


}
