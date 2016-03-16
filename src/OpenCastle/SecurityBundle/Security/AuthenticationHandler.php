<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 16.11.15
 * Time: 20:41.
 *
 * Handles Authentication in the game
 */

namespace OpenCastle\SecurityBundle\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Class AuthenticationHandler.
 * @codeCoverageIgnore
 */
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $array = array(
            'success' => 'false',
            'message' => 'Login ou mot de passe incorrect',
        );

        return new JsonResponse($array);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $array = array('success' => 'true');

        return new JsonResponse($array);
    }
}
