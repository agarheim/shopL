<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 10.07.19
 * Time: 19:52
 */

namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationService
{
    /**
     * @var EntityManagerInterface
     */
private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
private  $passwordEncoder;

    /**
     * @var MailerInterface
     */
private $mailer;

    /**
     * RegistrationService constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->mailer= $mailer;
    }
public function createUser(User $user)
{
    $hash= $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
    $user->setPassword($hash);
    $user->setEmailCheckCode(md5(random_bytes(32)));
    $this->entityManager->persist($user);
    $this->entityManager->flush();
    $this->sendEmailConfirmationMessage($user);
}
public function confirmEmail(User $user)
{
    $user->setIsMailChecked(true);
    $user->setEmailCheckCode(null);
    $this->entityManager->flush();
}
private function sendEmailConfirmationMessage(User $user)
{
 $message= new TemplatedEmail();
 $message->to(new NamedAddress($user->getEmail(), $user->getFullName()));
 $message->from('noreply@sgop.fg');
 $message->subject('Подтверждение регистрации');
 $message->htmlTemplate('security/emails/confirmation.html.twig');
 $message->context(['user' =>$user]);
 $this->mailer->send($message);

}
}