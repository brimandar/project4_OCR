<?php

namespace App\src\controller;

use App\config\Parameter;

class RegisterController extends Controller
{
    /**
     * register an user
     *
     * @param  array $post
     *
     * @return void
     */
    public function register(Parameter $post)
    {
        // If we are on register view and submit the form
        if($post->get('submit')) {

            $errors = $this->_validation->validate($post, 'User');
            // check if pseudo is already used. If TRUE, return an error
            if($this->_userDAO->checkUser($post)) {
                $errors['username'] = $this->_userDAO->checkUser($post);
            }
            if(!$errors) {
                $activationcode = $this->_userDAO->register($post);
                $this->_session->set('register', 'Pour confirmer votre inscription, merci de cliquer sur le lien dans le mail qui vient de vous être envoyé');
                // Send email for confirmation
                $to = $post->get('email');
                $subject ="Merci pour votre inscription à mon blog - Jean FORTEROCHE";
                $headers = "MIME-Version: 1.0"."\r\n";
                        $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
                        $headers .= 'From:Jean FORTEROCHE <rudy.steffler@gmail.com>'."\r\n";
                        
                $ms ="
                <html>
                <body>
                    <div>
                        <p>Bonjour " . $post->get('username') . ",
                        </p><br>";
                $ms.=
                        "<p>
                        Votre compte a bien été créé sur le blog de Jean FORTEROCHE. Pour confirmer et activer votre inscription, merci de cliquer sur le lien suivant.
                        </p>
                        <p><a href='/index.php?route=confirmation&code=" .$activationcode. "'>Cliquez pour activer votre compte</a>
                        </p>
                        <br>
                        <p> 
                        A très bientôt sur mon blog.<br>Jean FORTEROCHE
                        </p>
                    </div>
                </body>
                </html>";
                mail($to,$subject,$ms,$headers);
                // Return to home page
                header('Location: /index.php');
            }
            return $this->_view->render('register', [
                'post' => $post,
                'errors' => $errors
            ], 'Inscription');

        }
        // If form not completed, Go to the register view
        return $this->_view->render('register', [], 'Inscription');
    }

    /**
     * confirmation Email
     *
     * @param  string $code
     *
     * @return void
     */
    public function confirmationEmail($code)
    {
        $confirmationMsg = $this->_userDAO->confirmationEmail($code);
        $this->_session->set('confirmation', 'Votre inscription est bien confirmée et validée !');
        header('Location: /index.php');
        echo "<script>alert($confirmationMsg)</script>";
    }

}