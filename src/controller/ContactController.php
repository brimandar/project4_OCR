<?php

namespace App\src\controller;

use App\config\Parameter;

class ContactController extends Controller
{

/**
     * Forms contact = send mail
     *
     * @param  mixed $post
     *
     * @return void
     */
    public function contact(Parameter $post)
    {
        if($post->get('submit')) 
        {
            $errors = $this->_validation->validate($post, 'contact');
            if(!$errors) 
            {           
                // Build POST request recaptcha:
                $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                $recaptcha_secret = KEY_SERVER;
                $recaptcha_response = $post->get('recaptcha_response');
                // Make and decode POST request recaptcha:
                $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                $recaptcha = json_decode($recaptcha);
                // Take action based on the score returned:
                if ($recaptcha->score >= 0.5) 
                {
                    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                    $headers[] = "From: " . $post->get('name') . "<" . $post->get('email') . ">\r\n";
                    $toEmail = EMAIL_FORM;
                    $mailSubject = $post->get('title');
                    $mailBody = $post->get('content');
                    mail($toEmail, $mailSubject, $mailBody, implode("\r\n", $headers));
                    $this->_session->set('sendEmail', 'Votre message a bien été envoyé');
                    // Return home page
                    header('Location: index.php');
                }
            } else {
                return $this->_view->render('contact', [
                    'post' => $post,
                    'errors' => $errors
                ], 'Formulaire de contact');
            }
        }
        return $this->_view->render('contact', [], 'Formulaire de contact');
    }
}