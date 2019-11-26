<?php 
namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
use App\Form\PropertyType;

class AdminPropertyController extends AbstractController
{

    /**
     *  @var PropertyRepository
     */
    private $repository;

    
    /**
     *  @var ObjectManager
     */
    private $em;


    public function __construct(PropertyRepository $repository, ObjectManager $em) 
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     *  @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

         /**
     *  @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        //Creation du formulaire
        $form = $this->createForm(PropertyType::class, $property);
        // Recup des donnée de la request
        $form->handleRequest($request);

        // Si le form est valide 
        if ($form->isSubmitted() &&  $form->isValid()) {
            // On replie property avec les donnée que l'ont reçois
            $this->em->persist($property);
            // Enregistrer les nouvelles infos
            $this->em->flush();
            $this->addFlash('success', "Bien ajouté avec succès");
            return $this->redirectToRoute('admin.property.index');
        };

        return $this->render('admin/property/new.html.twig',  [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }


    /**
     *  @Route("/admin/property/{id}", name="admin.property.edit",  methods="GET|POST")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {
        //Creation du formulaire
        $form = $this->createForm(PropertyType::class, $property);
        // Recup des donnée de la request
        $form->handleRequest($request);

        // Si le form est valide 
        if ($form->isSubmitted() &&  $form->isValid()) {
            // Enregistrer les nouvelles infos
            $this->em->flush();
            $this->addFlash('success', "Bien modifié avec succès");
            return $this->redirectToRoute('admin.property.index');
        };

        return $this->render('admin/property/edit.html.twig',  [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

        /**
     *  @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', "Bien supprimé avec succès");
           return $this->redirectToRoute('admin.property.index');
         }
         return $this->redirectToRoute('admin.property.index');
    }


}