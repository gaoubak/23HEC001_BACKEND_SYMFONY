<?php

namespace App\Controller;

use App\Entity\Chanel;
use App\Entity\User;
use App\Form\ChanelType; 
use App\Repository\UserRepository;
use App\Manager\ChanelManager;
use App\Traits\ApiResponseTrait;
use App\Traits\FormHandlerTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormFactoryInterface;
use App\Repository\ChanelRepository; 
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/api/chanels")
 */
class ChanelController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $chanelManager;
    private $formFactory;
    private $chanelRepository;
    private $userRepository;
    private $serializer;

    public function __construct(ChanelManager $chanelManager,  UserRepository $userRepository,FormFactoryInterface $formFactory, ChanelRepository $chanelRepository, SerializerInterface $serializer )
    {
        $this->chanelManager = $chanelManager;
        $this->formFactory = $formFactory;
        $this->chanelRepository = $chanelRepository;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Rest\View(serializerGroups={"chanel"})
     * @Route("/", name="chanel_list", methods={"GET"})
     */
    public function listChanels()
    {
        $chanels = $this->chanelRepository->findAll();
        $serializeChanel =  $this->serializer->normalize($chanels, null, ['groups' => ['get_chanel']]);
        return $this->createApiResponse($serializeChanel, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"chanel"})
     * @Route("/user", name="user_chanels", methods={"GET"})
     */
    public function listUserChanels()
    {
        $currentUser = $this->getUser();

        $userChanels = $this->chanelRepository->findByUser($currentUser);
        $serializeChanel = $this->serializer->normalize($userChanels, null, ['groups' => ['get_my_chanel']]);
        return $this->createApiResponse($serializeChanel, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"chanel"})
     * @Route("/{id}", name="chanel_get", methods={"GET"})
     */
    public function getChanelAction(Chanel $chanel)
    {
        $serializeChanel =  $this->serializer->normalize($chanel, null, ['groups' => ['get_chanel']]);
        return $this->createApiResponse($serializeChanel, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"chanel"})
     * @Route("/create", name="chanel_create", methods={"POST"})
     */
    public function createChanelAction(Request $request)
    {
        $chanel = new Chanel();
        $form = $this->formFactory->create(ChanelType::class, $chanel); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->chanelManager->save($chanel);
            $this->chanelManager->flush();

            return $this->renderCreatedResponse('Chanel created successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"chanel"})
     * @Route("/update/{id}", name="chanel_update", methods={"PUT"})
     */
    public function updateChanelAction(Request $request, Chanel $chanel)
    {
        $form = $this->formFactory->create(ChanelType::class, $chanel); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->chanelManager->save($chanel);
            $this->chanelManager->flush();

            return $this->renderUpdatedResponse('Chanel updated successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

     /**
     * @Route("/addUser/{id}", name="add_user_to_channel", methods={"PUT"})
     */
    public function addUsersToChannel(Request $request, Chanel $chanel, Security $security)
    {
        $user = $security->getUser();

        if (!$user) {
            return $this->createApiResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['users']) || !is_array($data['users'])) {
            return $this->createApiResponse(['error' => 'Invalid input format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $userIds = $data['users'];

        foreach ($userIds as $userId) {
            $userToAdd = $this->userRepository->find($userId);

            if ($userToAdd && !$chanel->getUsers()->contains($userToAdd)) {
                $chanel->addUser($userToAdd);
            }
        }

        $this->chanelManager->flush();

        return $this->renderUpdatedResponse('Users added to the channel successfully');
    }

    /**
     * @Rest\View(serializerGroups={"chanel"})
     * @Route("/delete/{id}", name="chanel_delete", methods={"DELETE"})
     */
    public function deleteChanelAction(Chanel $chanel)
    {
        $this->chanelManager->removeChanel($chanel);

        return $this->renderDeletedResponse('Chanel deleted successfully');
    }
}
