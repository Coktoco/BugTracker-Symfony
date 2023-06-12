<?php

/*
 *  Access Denied Handler
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Class AccessDeniedHandler
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @param Request               $request
     * @param AccessDeniedException $accessDeniedException
     *
     * @return Response|null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        return new Response('You are not allowed to access this part of our site, retreat immediately!', 403);
    }
}
