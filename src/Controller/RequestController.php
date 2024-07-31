<?php

namespace App\Controller;

use App\DTO\RequestDTO;
use App\Entity\Projet;
use App\Entity\Request;
use App\Entity\User;
use App\Form\RequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/request")
 */
class RequestController extends AbstractApiController
{
    /**
     * @Route("/", name="Request_index")
     */
    public function index(): Response
    {
        $reqRepository = $this->getDoctrine()->getRepository(Request::class);

        $reqList = $reqRepository->findAll();
        $reqs= $reqRepository->requestsListDTO($reqList);


        return $this->respond($reqs);
    }
    /**
     * @Route("/projet/{id}", name="Project_request", methods={"GET"})
     */
    public function findByproject($id): Response
    {
        $ProjectRepository = $this->getDoctrine()->getRepository(Projet::class);
        $reqRepository = $this->getDoctrine()->getRepository(Request::class);
        $project=$ProjectRepository->find($id);
        $reqs = $reqRepository->findBy(["Project" => $project]);

        $reqss = $reqRepository->requestsListDTO($reqs);

        return $this->respond($reqss);
    }
    /**
     * @Route("/User/{id}", name="NBselection", methods={"GET"})
     */
    public function nbSelection($id): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $reqRepository = $this->getDoctrine()->getRepository(Request::class);
        $user=$userRepository->find($id);
        $reqs = $reqRepository->findBy(["Pro" => $user]);
        $nb = 0;
        foreach ($reqs as $req)
        {
            if($req->getStatus())
            {
                $nb++;
            }
        }
        return $this->respond($nb);
    }

    /**
     * @Route("/user/{id}", name="user_request", methods={"GET"})
     */
    public function findByPro($id): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $reqRepository = $this->getDoctrine()->getRepository(Request::class);
        $user=$userRepository->find($id);
        $reqs = $reqRepository->findBy(["Pro" => $user]);
        $reqss = $reqRepository->requestsListDTO($reqs);

        return $this->respond($reqss);
    }
    /**
     * @Route("/user/{idreqest}/{idowner}", name="accept_decline", methods={"GET"})
     */
    public function accept_decline($idreqest,$idowner): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $reqRepository = $this->getDoctrine()->getRepository(Request::class);
        $user=$userRepository->find($idowner);
        $reqs = $reqRepository->find($idreqest);
        $project= $reqs->getProject();

        if($project->getUser()==$user)
        {
            if($reqs->getStatus()==false)
            {
                $reqs->setStatus(true);
            }
            else
            {
                $reqs->setStatus(false);
            }
            $reqRepository->add($reqs);

            return $this->respond(new RequestDTO($reqs));
        }
        else
        {
            return $this->respond(
                new RequestDTO($reqs),
                Response::HTTP_UNAUTHORIZED,
                "t'as pas le proprietere de ce projet");
        }
    }
    /**
     * @Route("/new/{iduser}/{idProjet}", name="Project_new", methods={"POST"})
     */
    public function new(\Symfony\Component\HttpFoundation\Request $request, $iduser,$idProjet): Response
    {

        $req = new Request();

        $form = $this->buildForm(RequestType::class, $req);

        $form->handleRequest($request);//$form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {

            $reqRep = $this->getDoctrine()
                ->getRepository(
                    Request::class);
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $projetRepository = $this->getDoctrine()->getRepository(Projet::class);
            $user =$userRepository->find($iduser);
            $projet = $projetRepository->find($idProjet);
            if($projet)
            {
                $reqs = $reqRep->findBy(["Pro" => $user,"Project"=>$projet]);
                if(!$reqs)
                {
                    if($user->getRoles()==['ROLE_PRO'])
                    {

                        $req->setProject($projet);
                        $req->setPro($user);
                        $req->setStatus(false);
                        $reqRep->add($req);

                        return $this->respond(
                            new RequestDTO($req),
                            Response::HTTP_OK
                        );
                    }


                }
                else
                {
                    return $this->respond(
                        $form->getErrors(),
                        Response::HTTP_BAD_REQUEST,
                        "t'as deja passer une demande");

                }
            }else
            {
                return $this->respond(
                    $form->getErrors(),
                    Response::HTTP_BAD_REQUEST,
                    "le projet n'existe pas ");

            }


        }
        else {

            return $this->respond(
                $form->getErrors(),
                Response::HTTP_BAD_REQUEST,
                "Invalid Fields");
        }
    }
}
