<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EmailController extends AbstractController
{
    /**
     * This acton for generate random test and send Emails based on a contact form
     *
     * @Route("/email", name="email")
     * @param MailerService $mailerService
     * @param Request $request
     * @return Response
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(MailerService $mailerService, Request $request) :Response
    {
        $text=$this->textGenerator();
        $form=$this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message=$request->get('contact')['message'] ? $request->get('contact')['message'] : null;
            $name   =$request->get('contact')['name']    ? $request->get('contact')['name']    : null;
            $email  =$request->get('contact')['email']   ? $request->get('contact')['email']   : null;
            $color  =$request->get('contact')['color']   ? $request->get('contact')['color']   : null;
            if (($message && $name && $email && $color) != null) {
                $mailerService->Send(
                    $email,
                    $email,
                    'Email test',
                    "email/template.html.twig",
                    [
                        'color' => $color, 'name' =>  $name, 'text' => $text.$message
                    ]
                );
                $this->addFlash('success', "formulaire  est bien summit");
                return $this->redirectToRoute('email');
            }
        }
        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
            'text' => $text,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param string $characters
     * @param int $length
     * @return string
     */
    public function textGenerator(string $characters = "0123456789abcdefghijklmnopqrstuvwxyz", int $length = 200)
    {
        $charactersLength = strlen($characters);
        $randomString = null;
        for ($i = 0; $i < $length; $i++) {
            if (!($i%5)) {
                $randomString .= " ".$characters[rand(0, $charactersLength - 1)];
            } else {
                $randomString .=$characters[rand(0, $charactersLength - 1)];
            }
        }
        return $randomString;
    }

    /**
     * @return array
     */
    public function creteRangeStrNum()
    {
        return array_merge(range(0, 9),range('a', 'z'));
    }
}
