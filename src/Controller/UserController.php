<?php
namespace App\Controller;

use App\DTO\ProDTO;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserAuthType;
use App\DTO\UserDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractApiController 
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
        public function index(): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $usersList = $userRepository->findUsersByRoles(['ROLE_USER']);
        $users= $userRepository->usersListDTO($usersList);

        
        return $this->respond($users);
    }

    /**
     * @Route("/Profile/{id}", name="user_Profile", methods={"GET"})
     */
    public function Profile($id): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->find($id);


    if($user->getRoles()== ['ROLE_USER'])
        {
            return $this->respond(new UserDTO($user));
        }else
            {
                return $this->respond(new ProDTO($user));
            }

    }
    /**
     * @Route("/{id}", name="user_remove", methods={"DELETE"})
     */
    public function remove($id): Response
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepository->find($id);


        $userRepository->remove($user);
        return $this->respond(new UserDTO($user));
    }
    /**
     * @Route("/new", name="user_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {

        $user = new User();

        $form = $this->buildForm(UserType::class, $user);
        
        $form->handleRequest($request);//$form->submit($request->request->all());
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            if($userRepository->findOneByUsername($user->getUsername())) {                
                
                return $this->respond(
                    $form->getErrors(),
                    Response::HTTP_UNAUTHORIZED,
                    "Username alredy exists"
                );
            }
            else {

                $userRepository->encodePassword($user);
                $userRepository->save($user);
                
                return $this->respond(
                    new UserDTO($user),
                    Response::HTTP_OK
                );
            }
        }
        else {

            return $this->respond(
                $form->getErrors(),
                Response::HTTP_UNAUTHORIZED,
                "Invalid Fields");                
        }
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"POST","PUT"})
     */
    public function edit(Request $request,$id): Response
    {
        $user = new User();

        $form = $this->buildForm(UserType::class, $user);

        $form->handleRequest($request);
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        if ($form->isSubmitted() && $form->isValid() && $userRepository->find($id) ) {
            $userRepository->encodePassword($user);

            $this->getDoctrine()->getManager()->flush();

            return $this->respond(
                new UserDTO($user),
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
     * @Route("/auth", methods={"POST"})
     */
    public function auth(Request $request)
    { 
        $user = new User();

        $form = $this->buildForm(UserAuthType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            if($userResult = $userRepository->auth($user)) {
                if ($userResult->isVerified())
                {
                    return $this->respond(
                        new UserDTO($userResult),
                        Response::HTTP_OK
                    );
                }

            }
            else
            {
                return $this->respond(
                    $form->getErrors(),
                    Response::HTTP_UNAUTHORIZED,
                    "Username or Password incorrect");
            }
        }
        else {

            return $this->respond(
                $form->getErrors(),
                Response::HTTP_UNAUTHORIZED,
                "Invalid Fields");
        }
    }
}