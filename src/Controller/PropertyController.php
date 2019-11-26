<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;

class PropertyController extends AbstractController
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
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(): Response 
    {
        // create
        // $property = new Property;
        // $property->setTitle('Mon premier bien')
        //     ->setPrice(500)
        //     ->setBedrooms(3)
        //     ->setSurface(60)
        //     ->setRooms(4)
        //     ->setFloor(2)
        //     ->setHeat(1)
        //     ->setCity('Lyon')
        //     ->setAddress("15 rue de Démo")
        //     ->setPostalCode('69003');
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);        
        // $em->flush();

        // $property = $this->repository->findAllVisible();
        // dump($property);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug):Response 
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}