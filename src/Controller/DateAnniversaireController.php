<?php

namespace App\Controller;

use App\Entity\DateAnniversaire;
use App\Form\DateAnniversaireType;
use App\Repository\DateAnniversaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/date/anniversaire")
 */
class DateAnniversaireController extends AbstractController
{
    /**
     * @Route("/", name="app_date_anniversaire_index", methods={"GET"})
     */
    public function index(DateAnniversaireRepository $dateAnniversaireRepository): Response
    {
        $today = new \DateTime();
        $days40 = (clone $today)->modify('+40 days');
    
        $dateAnniversaires = $dateAnniversaireRepository->findBy([], ['date' => 'ASC']);
    
        $dateAnniversaires = array_filter($dateAnniversaires, function ($a) use ($today, $days40) {
            $nextDateA = (clone $a->getDate())->setDate($today->format('Y'), $a->getDate()->format('m'), $a->getDate()->format('d'));
    
            if ($nextDateA < $today) {
                $nextDateA->modify('+1 year');
            }
    
            return $nextDateA >= $today && $nextDateA <= $days40;
        });
    
        usort($dateAnniversaires, function ($a, $b) use ($today) {
            $nextDateA = (clone $a->getDate())->setDate($today->format('Y'), $a->getDate()->format('m'), $a->getDate()->format('d'));
            $nextDateB = (clone $b->getDate())->setDate($today->format('Y'), $b->getDate()->format('m'), $b->getDate()->format('d'));
    
            if ($nextDateA < $today) {
                $nextDateA->modify('+1 year');
            }
    
            if ($nextDateB < $today) {
                $nextDateB->modify('+1 year');
            }
    
            return $nextDateA <=> $nextDateB;
        });
    
        return $this->render('date_anniversaire/index.html.twig', [
            'date_anniversaires' => $dateAnniversaires,
        ]);
    }
    
    /**
     * @Route("/new", name="app_date_anniversaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DateAnniversaireRepository $dateAnniversaireRepository): Response
    {
        $dateAnniversaire = new DateAnniversaire();
        $form = $this->createForm(DateAnniversaireType::class, $dateAnniversaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateAnniversaireRepository->add($dateAnniversaire, true);

            return $this->redirectToRoute('app_date_anniversaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('date_anniversaire/new.html.twig', [
            'date_anniversaire' => $dateAnniversaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_date_anniversaire_show", methods={"GET"})
     */
    public function show(DateAnniversaire $dateAnniversaire): Response
    {
        return $this->render('date_anniversaire/show.html.twig', [
            'date_anniversaire' => $dateAnniversaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_date_anniversaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DateAnniversaire $dateAnniversaire, DateAnniversaireRepository $dateAnniversaireRepository): Response
    {
        $form = $this->createForm(DateAnniversaireType::class, $dateAnniversaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateAnniversaireRepository->add($dateAnniversaire, true);

            return $this->redirectToRoute('app_date_anniversaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('date_anniversaire/edit.html.twig', [
            'date_anniversaire' => $dateAnniversaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_date_anniversaire_delete", methods={"POST"})
     */
    public function delete(Request $request, DateAnniversaire $dateAnniversaire, DateAnniversaireRepository $dateAnniversaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dateAnniversaire->getId(), $request->request->get('_token'))) {
            $dateAnniversaireRepository->remove($dateAnniversaire, true);
        }

        return $this->redirectToRoute('app_date_anniversaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
