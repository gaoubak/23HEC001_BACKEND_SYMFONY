<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Manager\MessageManager;
use App\Traits\ApiResponseTrait;
use App\Traits\FormHandlerTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormFactoryInterface;
use App\Repository\MessageRepository; 
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Mercure\MercureService;
use App\Service\Mercure\JwtMercureService;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\HubInterface;


/**
 * @Route("/api/messages")
 */
class MessageController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $messageManager;
    private $formFactory;
    private $messageRepository;
    private $serializer;
    private $hub;


    public function __construct(MessageManager $messageManager, FormFactoryInterface $formFactory, MessageRepository $messageRepository, SerializerInterface $serializer, HubInterface $hub)
    {
        $this->messageManager = $messageManager;
        $this->formFactory = $formFactory;
        $this->messageRepository = $messageRepository;
        $this->serializer = $serializer;
        $this->hub = $hub;
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/", name="message_list", methods={"GET"})
     */
    public function listMessages()
    {
        $messages = $this->messageRepository->findAll();
        $serializeMessage =  $this->serializer->normalize($messages, null, ['groups' => ['get_message']]);
        return $this->createApiResponse($serializeMessage, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/{id}", name="message_get", methods={"GET"})
     */
    public function getMessageAction(Message $message)
    {
        $serializeMessage =  $this->serializer->normalize($message, null, ['groups' => ['get_message']]);
        return $this->createApiResponse($serializeMessage, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/chanel/{id}", name="message_get_chanel", methods={"GET"})
     */
    public function getMessageByChanelAction(Request $request, int $id)
    {
        $messages = $this->messageRepository->findMessagesByChannelId(['id' => $id]);
        $serializeMessage =  $this->serializer->normalize($messages, null, ['groups' => ['get_message']]);
        return $this->createApiResponse($serializeMessage, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/user/{id}", name="message_get_user", methods={"GET"})
     */
    public function getMessageByUserAction(Request $request, int $id)
    {
        $messages = $this->messageRepository->findMessagesByUserId(['id' => $id]);
        $serializeMessage =  $this->serializer->normalize($messages, null, ['groups' => ['get_message']]);
        return $this->createApiResponse($serializeMessage, Response::HTTP_OK);
    }



    /**
     * @Route("/send", name="message_create", methods={"POST"})
     */
    public function createMessageAction(Request $request, MercureService $mercureService, JwtMercureService $jwtMercureService, HubInterface $hub)
    {
        $message = new Message();
        $form = $this->formFactory->create(MessageType::class, $message);
        $this->handleForm($request, $form);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageManager->save($message);
            $this->messageManager->flush();
    
            // Create JWT for Mercure authentication
            $jwt = $request->headers->get('MercureJWT');
            // Send a ping to notify about the new message
            $update = new Update(
                '/chat_room/'.$message->getChannel()->getId(),               
                 json_encode([
                    'username' => $message->getUser()->getUsername(),
                    'user_id' => $message->getUser()->getId(),
                    'content' => $message->getUserText(),
                    'channel' => $message->getChannel(),
                    'message_value' => $message->getUserText(),
                    'message_date' => $message->getDate()->format('Y-m-d H:i:s'),
                ]),
            );

                $data = $hub->publish($update);
                dd($data);
               
            
                return $this->renderCreatedResponse('Message created successfully');
           
        }
    
        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }
    



    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/update/{id}", name="message_update", methods={"PUT"})
     */
    public function updateMessageAction(Request $request, Message $message)
    {
        $form = $this->formFactory->create(MessageType::class, $message); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->messageManager->save($message);
            $this->messageManager->flush();

            return $this->renderUpdatedResponse('Message updated successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/delete/{id}", name="message_delete", methods={"DELETE"})
     */
    public function deleteMessageAction(Message $message)
    {
        $this->messageManager->removeMessage($message);

        return $this->renderDeletedResponse('Message deleted successfully');
    }
}
