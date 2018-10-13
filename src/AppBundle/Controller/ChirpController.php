<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chirp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Chirp controller.
 *
 * @Route("chirp")
 */
class ChirpController extends Controller
{
    /**
     * Lists all chirp entities.
     *
     * @Route("/", name="chirp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chirps = $em->getRepository('AppBundle:Chirp')->findAll();

        return $this->render('chirp/index.html.twig', array(
            'chirps' => $chirps,
        ));
    }

    /**
     * Creates a new chirp entity.
     *
     * @Route("/new", name="chirp_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $chirp = new Chirp();
        $form = $this->createForm('AppBundle\Form\ChirpType', $chirp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chirp);
            $em->flush();

            return $this->redirectToRoute('chirp_show', array('id' => $chirp->getId()));
        }

        return $this->render('chirp/new.html.twig', array(
            'chirp' => $chirp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a chirp entity.
     *
     * @Route("/{id}", name="chirp_show")
     * @Method("GET")
     */
    public function showAction(Chirp $chirp)
    {
        $deleteForm = $this->createDeleteForm($chirp);

        return $this->render('chirp/show.html.twig', array(
            'chirp' => $chirp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chirp entity.
     *
     * @Route("/{id}/edit", name="chirp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chirp $chirp)
    {
        $deleteForm = $this->createDeleteForm($chirp);
        $editForm = $this->createForm('AppBundle\Form\ChirpType', $chirp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chirp_edit', array('id' => $chirp->getId()));
        }

        return $this->render('chirp/edit.html.twig', array(
            'chirp' => $chirp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a chirp entity.
     *
     * @Route("/{id}", name="chirp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chirp $chirp)
    {
        $form = $this->createDeleteForm($chirp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chirp);
            $em->flush();
        }

        return $this->redirectToRoute('chirp_index');
    }

    /**
     * Creates a form to delete a chirp entity.
     *
     * @param Chirp $chirp The chirp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chirp $chirp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chirp_delete', array('id' => $chirp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
