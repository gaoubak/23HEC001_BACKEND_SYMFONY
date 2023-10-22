<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType; // Import the custom form
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


/**
 * @Route("/messages")
 */
class MessageController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $messageManager;
    private $formFactory;
    private $messageRepository;
    private $serializer;


    public function __construct(MessageManager $messageManager, FormFactoryInterface $formFactory, MessageRepository $messageRepository, SerializerInterface $serializer)
    {
        $this->messageManager = $messageManager;
        $this->formFactory = $formFactory;
        $this->messageRepository = $messageRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/", name="message_list", methods={"GET"})
     */
    public function listMessages()
    {
        $messages = $this->messageRepository->findAll();
        return $this->createApiResponse($messages, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/{id}", name="message_get", methods={"GET"})
     */
    public function getMessageAction(Message $message)
    {
        return $this->createApiResponse($message, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/", name="message_create", methods={"POST"})
     */
    public function createMessageAction(Request $request)
    {
        $message = new Message();
        $form = $this->formFactory->create(MessageType::class, $message); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->messageManager->save($message);
            $this->messageManager->flush();

            return $this->renderCreatedResponse('Message created successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"message"})
     * @Route("/{id}", name="message_update", methods={"PUT"})
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
     * @Route("/{id}", name="message_delete", methods={"DELETE"})
     */
    public function deleteMessageAction(Message $message)
    {
        $this->messageManager->removeMessage($message);

        return $this->renderDeletedResponse('Message deleted successfully');
    }
}
