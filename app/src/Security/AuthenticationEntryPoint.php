<?php
/*
 * Entry Point Authentication
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AuthenticationEntryPoint.
 */
class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param UrlGeneratorInterface $urlGenerator Url Generator
     */
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    /**
     * Start the authentication.
     *
     * @param Request                      $request       request
     * @param AuthenticationException|null $authException authException
     *
     * @return RedirectResponse Redirect response
     */
    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        // add a custom flash message and redirect to the login page
        $request->getSession()->getFlashBag()->add('note', 'You have to login in order to access this page.');

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
