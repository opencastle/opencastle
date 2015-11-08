<?php

namespace OpenCastle\SecurityBundle\Controller;

use OpenCastle\SecurityBundle\Form\Type\Player\InscriptionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        $form = $this->createForm(new InscriptionFormType(), $player);

        if($request->getMethod() === 'POST')
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                // ajout du user au groupe de base
                $entityManager = $this->getDoctrine()->getManager();

                $playerManager->updatePlayer($player);
            }
        }

        // retourner la vue
    }

    public function connexionAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // retourner la vue
    }

}
