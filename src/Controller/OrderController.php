<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Order;
use App\Entity\ReceiveOrder;
use App\Form\MovieType;
use App\Form\OrderType;
use App\Form\ReceiveOrderType;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Movie controller.
 * @Route("/api", name="api_")
 */
class OrderController extends AbstractController
{
    use ControllerTrait;
    /**
     * @param ViewHandlerInterface $handler
     */
    public function __construct(ViewHandlerInterface $handler)
    {
        $this->setViewHandler($handler);
    }

    /**
     * @Rest\Post("/order", name="order")
     */
    public function postMovieAction(Request $request)
    {
        $receiveOrder = new receiveOrder();
        $form = $this->createForm(ReceiveOrderType::class, $receiveOrder);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {

            $movie = $this->getDoctrine()->getRepository(Movie::class)->find($receiveOrder->getMovieID());

            $order = new Order();
            $order->setUserID($receiveOrder->getUserID());
            $order->setUserName($receiveOrder->getUserName());
            $order->addMovie($movie);

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            $movie->setSlot($movie->getSlot()-2);
            $em->flush();


            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}
