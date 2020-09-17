<?php


namespace App\Services;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailerService
{

    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(Environment $twig, MailerInterface $mailer)
    {

        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $template
     * @param array $parameters
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function send(string $from, string $to, string $subject, string $template, array $parameters): void
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($from)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text('Sending emails is fun again!')
//            ->html('<p>See Twig integration for better HTML integration!</p>');
            ->html(
                $this->twig->render($template, $parameters),
                'text/html'
            );

        $this->mailer->send($email);
    }
}
