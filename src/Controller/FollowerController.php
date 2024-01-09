<?php 

namespace App\Controller;

use App\Entity\Follower;
use App\Entity\User;
use App\Form\FollowerType;
use App\Service\FollowerService; 
use App\Manager\FollowerManager;
use App\Traits\ApiResponseTrait;
use App\Traits\FormHandlerTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormFactoryInterface;
use App\Repository\FollowerRepository; 
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/followers")
 */
class FollowerController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $followerManager;
    private $formFactory;
    private $followerRepository;
    private $serializer;
    private $followerService;

    public function __construct(FollowerManager $followerManager, FormFactoryInterface $formFactory, FollowerRepository $followerRepository, SerializerInterface $serializer, FollowerService $followerService)
    {
        $this->followerManager = $followerManager;
        $this->formFactory = $formFactory;
        $this->followerRepository = $followerRepository;
        $this->serializer = $serializer;
        $this->followerService = $followerService;
    }


    /**
     * @Rest\View(serializerGroups={"follower"})
     * @Route("/", name="follower_list", methods={"GET"})
     */
    public function listFollowers()
    {
        $followers = $this->followerRepository->findAll();
        $serializeFollower =  $this->serializer->normalize($followers, null, ['groups' => ['get_follower']]);
        return $this->createApiResponse($serializeFollower, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"get_follower"})
     * @Route("/{id}", name="follower_get", methods={"GET"})
     */
    public function getFollowerAction(Follower $follower)
    {
        $serializeFollower = $this->serializer->normalize($follower, null, ['groups' => ['get_follower']]);
        return $this->createApiResponse($serializeFollower, Response::HTTP_OK);
    }
   
    /**
     * @Rest\View(serializerGroups={"get_follower"})
     * @Route("/user-followers", name="user_followers", methods={"GET"})
     */
    public function listUserFollowers(User $user)
    {
        $userFollowers = $this->followerRepository->findByUser($user);
        $serializeFollowers = $this->serializer->normalize($userFollowers, null, ['groups' => ['get_follower']]);
        return $this->createApiResponse($serializeFollowers, Response::HTTP_OK);
    }


    /**
     * @Route("/create", name="follower_create", methods={"POST"})
     */
    public function createFollowerAction(Request $request)
    {
        $follower = new Follower();
        $form = $this->formFactory->create(FollowerType::class, $follower); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->followerService->createFollowerWithChanel($follower);

            return $this->renderCreatedResponse('Follower created successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"follower"})
     * @Route("/update/{id}", name="follower_update", methods={"PUT"})
     */
    public function updateFollowerAction(Request $request, Follower $follower)
    {
        $form = $this->formFactory->create(FollowerType::class, $follower); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->followerManager->save($follower);
            $this->followerManager->flush();

            return $this->renderUpdatedResponse('Follower updated successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"follower"})
     * @Route("/delete/{id}", name="follower_delete", methods={"DELETE"})
     */
    public function deleteFollowerAction(Follower $follower)
    {
        $this->followerManager->removeFollower($follower);

        return $this->renderDeletedResponse('Follower deleted successfully');
    }
}
