<?php

namespace OpenCastle\SecurityBundle\Controller;

use OpenCastle\SecurityBundle\Form\Type\Player\InscriptionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 * Manages the connection and inscription to the game,
 */
class SecurityController extends Controller
{

    public function inscriptionAction(Request $request)
    {
        $playerManager = $this->get('opencastle_security.player_manager');

        $player = $playerManager->createPlayer();

        $form = $this->createForm(new InscriptionFormType(), $player, array(
            'action' => $this->generateUrl('opencastle_security.inscription')
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // ajout du user au groupe de base
                $entityManager = $this->getDoctrine()->getManager();

                $playerManager->updatePlayer($player);

                return new JsonResponse(array(
                    "status" => "ok",
                    "message" => "Votre compte a bien été créé!",
                ));
            } else {
                return new JsonResponse(array(
                    "status" => "ko",
                    "errors" => $this->get('jms_serializer')->serialize($form, 'json')
                ));
            }
        }

        // retourner la vue
        return $this->render('OpenCastleSecurityBundle:Player:inscription.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function connexionAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // retourner la vue
        return $this->render('OpenCastleSecurityBundle:Player:connexion.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error
        ));
    }

}
