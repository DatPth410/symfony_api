<?php
namespace App\Controller;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Form\MovieType;
/**
 * Movie controller.
 * @Route("/api", name="api_")
 */
class MovieController extends AbstractController
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
     * Lists all Movies.
     * @Rest\Get("/movies")
     *
     * @return Response
     */

    public function getMovieAction()
    {
        $repository = $this->getDoctrine()->getRepository(Movie::class);
        $movies = $repository->findall();
        return $this->handleView($this->view($movies));
    }
    /**
     * Create Movie.
     * @Rest\Post("/movie")
     *
     * @return Response
     */
    public function postMovieAction(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Removes the Article resource
     * @Rest\Delete("/movie/{movieId}")
     *
     */
    public function deleteMovieAction(int $movieId)
    {
        $movie = $this->getDoctrine()->getRepository(Movie::class)->find($movieId);

        if ($movie) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movie);
            $em->flush();
        }
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
    }

}