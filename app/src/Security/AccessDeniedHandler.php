<?php
/*
 *  Access Denied Handler
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AccessDeniedHandler.
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Access denied handler.
     *
     * @param Request               $request               request
     * @param AccessDeniedException $accessDeniedException AccessDeniedException
     *
     * @return Response|null ?Response
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $message = $this->translator->trans('access_denied_message');

        return new Response($message, 403);
    }
}
