<?php
/**
 * Change password controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Model\ChangePasswordModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ChangePasswordController.
 */
class ChangePasswordController extends AbstractController
{
    /**
     * Entity manager.
     */
    private EntityManagerInterface $entityManager;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager Entity Manager
     * @param TranslatorInterface    $translator    Translator
     */
    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    /**
     * ChangePassword action.
     *
     * @param Request                     $request        HTTP Request
     * @param UserPasswordHasherInterface $passwordHasher Password Hasher
     *
     * @return Response HTTP response
     */
    #[Route('/change-password', name: 'user_change_password', methods: 'GET|POST')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        // Not logged in, cannot change password
        if (!$user instanceof User) {
            throw new AccessDeniedException();
        }

        $changePasswordModel = new ChangePasswordModel();
        $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if old password is valid
            if (!$passwordHasher->isPasswordValid($user, $changePasswordModel->getOldPassword())) {
                $form->addError(new FormError($this->translator->trans('message.password_incorrect')));
            } else {
                $newPassword = $passwordHasher->hashPassword($user, $changePasswordModel->getNewPassword());
                $user->setPassword($newPassword);

                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    $this->translator->trans('message.password_changed')
                );

                return $this->redirectToRoute('bug_index');
            }
        }

        return $this->render('user/changePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
