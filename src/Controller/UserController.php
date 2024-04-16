<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Chanel;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Traits\ApiResponseTrait;
use App\Traits\FormHandlerTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/api/users")
 */
class UserController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $userManager;
    private $formFactory;
    private $userRepository;
    private $serializer;

    public function __construct(UserManager $userManager, FormFactoryInterface $formFactory, UserRepository $userRepository, SerializerInterface $serializer)
    {
        $this->userManager = $userManager;
        $this->formFactory = $formFactory;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Rest\View(serializerGroups={"get_user"})
     * @Route("/current", name="get_current_user", methods={"GET"})
     */
    public function getCurrentUserAction()
    {
        $user = $this->getUser();

        $serializedUser = $this->serializer->normalize($user, null, ['groups' => ['get_current_user']]);
        return $this->createApiResponse($serializedUser, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"get_user"})
     * @Route("/current-follower", name="get_current_user_follower", methods={"GET"})
     */
    public function getCurrentUserFollowerAction()
    {
        $user = $this->getUser();
        $followers = $user->getFollowers();

        $followersData = [];
        foreach ($followers as $follower) {
            $followersData[] = [
                'id' => $follower->getFollower()->getId(),
                'username' => $follower->getFollower()->getUsername(),
                'email' => $follower->getFollower()->getEmail(),
                'userPhoto' => $follower->getFollower()->getUserPhoto(),
                'description' => $follower->getFollower()->getDescription(),
            ];
        }

        return $this->createApiResponse($followersData, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={""})
     * @Route("/current-chanel", name="get_current_user_chanel", methods={"GET"})
     */
    public function getCurrentUserChanlAction()
    {
        $user = $this->getUser();
        $chanels = $user->getChanels();

        $chanelsData = [];
        foreach ($chanels as $chanel) {
            // Ensure $chanel is an instance of the Chanel entity
                $chanelsData[] = [
                    'id' => $chanel->getId(),
                    'user' => $chanel->getUsers()
                    //'followers' => $chanel->getFollowers(),
                    //'chanel' => $chanel->getChanel()->getFollowers(),
                ];
        }
        return $this->createApiResponse($chanelsData, Response::HTTP_OK);
    }


    /**
     * @Rest\View(serializerGroups={"get_user"})
     * @Route("/", name="list_user", methods={"GET"})
     */
    public function listUsers()
    {
        $users = $this->userRepository->findAll();
        $serializedUsers = $this->serializer->normalize($users, null, ['groups' => ['get_user']]);
        return $this->createApiResponse($serializedUsers, Response::HTTP_OK);
 
    }

    /**
     * @Rest\View(serializerGroups={"get_user"})
     * @Route("/{id}", name="get_user", methods={"GET"})
     */
    public function getUserAction(User $user)
    {
        $serializedUsers = $this->serializer->normalize($user, null, ['groups' => ['get_user']]);
        return $this->createApiResponse($serializedUsers, Response::HTTP_OK);
    }


    /**
     * @Rest\View(serializerGroups={"user"})
     * @Route("/register", name="create_user", methods={"POST"})
     */
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $this->handleForm($request, $form);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT); // Use password_hash
            $user->setPassword($hashedPassword);
            
            $this->userManager->save($user);
            $this->userManager->flush();

            return $this->renderCreatedResponse('User registered successfully');
        }

        // If the form is not valid, you can return an error response
        return $this->createApiResponse(['message' => 'User registration failed', 'errors' => $form->getErrors()], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Route("/update", name="update_current_user", methods={"PUT"})
     */
    public function updateCurrentUser(Request $request)
    {
        $user = $this->getUser();
        $form = $this->formFactory->create(UserType::class, $user);
        $this->handleForm($request, $form);

        if ($form->isValid()) {

            $this->userManager->save($user);
            $this->userManager->flush();

            return $this->renderUpdatedResponse('User updated successfully');
        }

         return $this->createApiResponse($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }           


    /**
     * @Rest\View(serializerGroups={"user"})
     * @Route("/delete/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser(User $user)
    {
        $this->userManager->removeUser($user);

        return $this->renderDeletedResponse('User deleted successfully');
    }
}
