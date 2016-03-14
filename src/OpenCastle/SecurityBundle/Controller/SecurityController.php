<?php

namespace OpenCastle\SecurityBundle\Controller;

use OpenCastle\SecurityBundle\Form\Type\Player\InscriptionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 * Manages the connection and inscription to the game,.
 */
class SecurityController extends Controller
{
    /**
     * Shows and handles the subscription form.
     *
     * @param Request $request
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function inscriptionAction(Request $request)
    {
        $playerManager = $this->get('opencastle_security.player_manager');

        $player = $playerManager->createPlayer();

        $form = $this->createForm(InscriptionFormType::class, $player, array(
            'action' => $this->generateUrl('opencastle_security.inscription'),
        ));

        // Handle form submission if the request is of the POST type
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // add the default group to the player
                $groupManager = $this->get('opencastle_security.group_manager');
                $player->addGroup($groupManager->getDefaultGroup());

                $playerManager->updatePlayer($player);

                return new JsonResponse(array(
                    'status' => 'ok',
                    'message' => 'Votre compte a bien été créé!',
                ));
            } else {
                return new JsonResponse(array(
                    'status' => 'ko',
                    'errors' => $this->get('jms_serializer')->serialize($form, 'json'),
                ));
            }
        }

        // render the view
        return $this->render('OpenCastleSecurityBundle:Player:inscription.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Shows and handles the connexion form
     * see http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
     *
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function connexionAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // render the view
        return $this->render('OpenCastleSecurityBundle:Player:connexion.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }
}
