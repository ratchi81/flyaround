<?php

namespace WCS\CoavBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

use WCS\CoavBundle\Entity\Review;

/**
 * Review controller.
 *
 * @Route("review")
 */

class ReviewController extends Controller
{
    /**
     * Lists all review entities.
     *
     * @Route("/{review_id}", name="review_index" , requirements={"review_id": "\d+"})
     * @Method("GET")
     * @ParamConverter("review",   options={"mapping": {"review_id": "id"}})
     */

    public function indexAction(Review $review)
    {
        return $this->render('review/index.html.twig', array(
                'review' => $review,
        ));
    }

    /**
     * Creates a new review entity.
     *
     * @Route("/new", name="review_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $review = new Review();
        $form = $this->createForm('WCS\CoavBundle\Form\ReviewType', $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('review_show', array('id' => $review->getId()));
        }

        return $this->render('review/new.html.twig', array(
            'review' => $review,
            'form' => $form->createView(),
        ));
    }

}
