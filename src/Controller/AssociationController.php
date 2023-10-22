<?php 

namespace App\Controller;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Manager\AssociationManager;
use App\Traits\ApiResponseTrait;
use App\Traits\FormHandlerTrait;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use App\Repository\AssociationRepository; 
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;



/**
 * @Route("/associations")
 */
class AssociationController extends AbstractFOSRestController
{
    use ApiResponseTrait;
    use FormHandlerTrait;

    private $associationManager;
    private $formFactory;
    private $associationRepository;
    private $serializer;

    public function __construct(AssociationManager $associationManager, FormFactoryInterface $formFactory, AssociationRepository $associationRepository, SerializerInterface $serializer)
    {
        $this->associationManager = $associationManager;
        $this->formFactory = $formFactory;
        $this->associationRepository = $associationRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Rest\View(serializerGroups={"association"})
     * @Route("/", name="association_list", methods={"GET"})
     */
    public function listAssociations()
    {
        $associations = $this->associationRepository->findAll();
        return $this->createApiResponse($associations, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"association"})
     * @Route("/{id}", name="association_get", methods={"GET"})
     */
    public function getAssociationAction(Association $association)
    {
        return $this->createApiResponse($association, Response::HTTP_OK);
    }

    /**
     * @Rest\View(serializerGroups={"association"})
     * @Route("/", name="association_create", methods={"POST"})
     */
    public function createAssociationAction(Request $request)
    {
        $association = new Association();
        $form = $this->formFactory->create(AssociationType::class, $association); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->associationManager->save($association);
            $this->associationManager->flush();

            return $this->renderCreatedResponse('Association created successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"association"})
     * @Route("/{id}", name="association_update", methods={"PUT"})
     */
    public function updateAssociationAction(Request $request, Association $association)
    {
        $form = $this->formFactory->create(AssociationType::class, $association); // Use the custom form
        $this->handleForm($request, $form);

        if ($form->isValid()) {
            $this->associationManager->save($association);
            $this->associationManager->flush();

            return $this->renderUpdatedResponse('Association updated successfully');
        }

        return $this->createApiResponse($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(serializerGroups={"association"})
     * @Route("/{id}", name="association_delete", methods={"DELETE"})
     */
    public function deleteAssociationAction(Association $association)
    {
        $this->associationManager->removeAssociation($association);

        return $this->renderDeletedResponse('Association deleted successfully');
    }
}
