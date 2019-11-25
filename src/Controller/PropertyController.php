<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Twig\Environment;

class PropertyController extends AbstractController
{

    /**
     *  @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository) 
    {
        $this->repository = $repository;
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

        $property = $this->repository->find(1);
        dump($property);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}