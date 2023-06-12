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
     * @param TranslatorInterface   $translator   translator
     */
    public function __construct(private UrlGeneratorInterface $urlGenerator, TranslatorInterface $translator)
    {
        $this->translator = $translator;
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
        $message = $this->translator->trans('access.denied_login_message');

        $request->getSession()->getFlashBag()->add('note', $message);

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
