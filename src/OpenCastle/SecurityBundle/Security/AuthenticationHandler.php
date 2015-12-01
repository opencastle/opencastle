<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 16.11.15
 * Time: 20:41
 *
 * Handles Authentication in the game
 */

namespace OpenCastle\SecurityBundle\Security;

use OpenCastle\CoreBundle\GameEvent\GameEventHandler;
use OpenCastle\SecurityBundle\GameEvent\PlayerConnectedGameEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var PlayerConnectedGameEvent
     */
    private $event;

    public function __construct(
        Session $session,
        TranslatorInterface $translator,
        EventDispatcherInterface $eventDispatcher,
        PlayerConnectedGameEvent $event
    ) {
        $this->session = $session;
        $this->translator = $translator;
        $this->eventDispatcher = $eventDispatcher;
        $this->event = clone $event;
    }

    /**
     * @inheritdoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $array = array(
            'success' => 'false',
            'message' => 'Login ou mot de passe incorrect'
        );

        return new JsonResponse($array);
    }


    /**
     * @inheritdoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $array = array('success' => 'true');

        $this->event->setReceiver($token->getUser());

        $this->eventDispatcher->dispatch(GameEventHandler::GAME_EVENT, $this->event);

        return new JsonResponse($array);
    }
}
