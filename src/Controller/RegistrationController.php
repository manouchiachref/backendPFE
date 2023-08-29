<?php

namespace App\Controller;

use App\DTO\ProDTO;
use App\Entity\User;
use App\Form\EmailType;
use App\Form\ProType;
use App\Form\UserType;

use App\DTO\UserDTO;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractApiController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register" ,methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
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
                $roles[] = 'ROLE_USER';
                $user->setRoles($roles);
                $user->setPassword(
                    $userPasswordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                    (new TemplatedEmail())
                        ->from(new Address('hassen.ahmadi@esprit.tn', 'pfe'))
                        ->to($user->getUsername())
                        ->subject('Please Confirm your Email')
                        ->htmlTemplate('registration/confirmation_email.html.twig')
                );
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
     * @Route("/sendVerifMail", name="verify_email",methods={"POST"})
     */
    public function sendVerif(Request $request)
    {
        $user = new User();
        $form = $this->buildForm(EmailType::class, $user);

        $form->handleRequest($request);//$form->submit($request->request->all());


        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository = $this->getDoctrine()->getRepository(User::class);
            if(!$userRepository->findOneByUsername($user->getUsername())) {

                return $this->respond(
                    $form->getErrors(),
                    Response::HTTP_UNAUTHORIZED,
                    "Username does not exists"
                );
            }
            else {
                $user=$userRepository->findOneByUsername($user->getUsername());
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                    (new TemplatedEmail())
                        ->from(new Address('hassen.ahmadi@esprit.tn', 'pfe'))
                        ->to($user->getUsername())
                        ->subject('Please Confirm your Email')
                        ->htmlTemplate('registration/confirmation_email.html.twig')
                );
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
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
    /**
     * @Route("/registerPro", name="register_Pro" ,methods={"POST"})
     */
    public function registerPro(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->buildForm(ProType::class, $user);

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
                $roles[] = 'ROLE_PRO';
                $user->setRoles($roles);
                $user->setPassword(
                    $userPasswordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                    (new TemplatedEmail())
                        ->from(new Address('hassen.ahmadi@esprit.tn', 'pfe'))
                        ->to($user->getUsername())
                        ->subject('Please Confirm your Email')
                        ->htmlTemplate('registration/confirmation_email.html.twig')
                );
                return $this->respond(
                    new ProDTO($user),
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
}
