<?php
/**
 * Change info controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangeInfoType;
use App\Model\ChangeInfoModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ChangeInfoController.
 */
class ChangeInfoController extends AbstractController
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
     * ChangeEmail action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/change-email', name: 'user_change_email', methods: 'GET|POST')]
    public function changeEmail(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedException();
        }

        $changeEmailModel = new ChangeInfoModel();
        $form = $this->createForm(ChangeInfoType::class, $changeEmailModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEmail($changeEmailModel->getEmail());
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                $this->translator->trans('message.email_changed')
            );

            return $this->redirectToRoute('bug_index');
        }

        return $this->render('user/changeInfo.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
