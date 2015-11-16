<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 16.11.15
 * Time: 20:41
 */

namespace OpenCastle\SecurityBundle\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $array = array( 'success' => 'false', 'message' => $exception->getMessage() ); // data to return via JSON
        return new JsonResponse($array);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $array = array('success' => 'true');

        return new JsonResponse($array);
    }
}
