<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Projet;
use App\Entity\User;
use App\Form\ProjectType;
use App\DTO\ProjectDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Project")
 */
class ProjectController extends AbstractApiController
{
    /**
     * @Route("/", name="Project", methods={"GET"})
     */
    public function index(): Response
    {
        $ProjectRepository = $this->getDoctrine()->getRepository(Projet::class);

        $projectList = $ProjectRepository->findAll();

        $projects = $ProjectRepository->projetListDTO($projectList);

        return $this->respond($projects);
    }
    /**
     * @Route("/user/{id}", name="Project_index", methods={"GET"})
     */
    public function findByUser($id): Response
    {
        $ProjectRepository = $this->getDoctrine()->getRepository(Projet::class);
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user =$userRepository->find($id);
        $projectList = $ProjectRepository->findBy(["user" => $user]);

        $projects = $ProjectRepository->projetListDTO($projectList);

        return $this->respond($projects);
    }
    /**
     * @Route("/new/{id}", name="Projectsaadadad", methods={"POST"})
     */
    public function new(Request $request,$id): Response
    {

        $project = new Projet();

        $form = $this->buildForm(ProjectType::class, $project);

        $form->handleRequest($request);//$form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {

            $projectRep = $this->getDoctrine()
                ->getRepository(
                    Projet::class);
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user =$userRepository->find($id);
            $project->setUser($user);
            $projectRep->add($project);

            return $this->respond(
                new ProjectDTO($project),
                Response::HTTP_OK
            );


        }
        else {

            return $this->respond(
                $form->getErrors(),
                Response::HTTP_UNAUTHORIZED,
                "Invalid Fields");
        }
    }
    /**
     * @Route("/update/{iduser}/{id}", name="Project_update", methods={"POST"})
     */
    public function update(Request $request,$iduser,$id): Response
    {

        $project = new Projet();

        $form = $this->buildForm(ProjectType::class, $project);

        $form->handleRequest($request);//$form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {

            $projectRep = $this->getDoctrine()
                ->getRepository(
                    Projet::class);
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user =$userRepository->find($iduser);
            $pro= $projectRep->find($id);

            empty($project->getDescription()) ? true : $pro->setDescription($project->getDescription());
            empty($project->getType()) ? true : $pro->setType($project->getType());
            empty($project->getPrix()) ? true : $pro->setPrix($project->getPrix());
            empty($project->getDelais()) ? true : $pro->setDelais($project->getDelais());
            empty($project->getNomProjet()) ? true : $pro->setNomProjet($project->getNomProjet());
            empty($project->getZone()) ? true : $pro->setZone($project->getZone());
            empty($project->getPhoto()) ? true : $pro->setPhoto($project->getPhoto());
            empty($project->getTypebatiment()) ? true : $pro->setTypebatiment($project->getTypebatiment());
            $projectRep->update($pro);




            return $this->respond(
                new ProjectDTO($pro)
            );


        }
        else {

            return $this->respond(
                $form->getErrors(),
                Response::HTTP_UNAUTHORIZED,
                "Invalid Fields");
        }
    }
    /**
     * @Route("/{id}", name="Project_remove", methods={"DELETE"})
     */
    public function remove($id): Response
    {
        $ProjectRepository = $this->getDoctrine()->getRepository(Projet::class);

        $project= $ProjectRepository->find($id);

       $ProjectRepository->remove($project);

        return $this->respond(null,200,);

    }
}
