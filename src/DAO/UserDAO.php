<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\User;
use App\src\model\Pagination;

class UserDAO extends DAO
{
    /**
     * register an user - default role = user
     *
     * @param  array $post
     *
     * @return object
     */
    public function register(Parameter $post)
    {
        $activationcode = md5($post->get('email').time());
        $sql = 'INSERT INTO users (username, password, email, created_at, role_id, activationcode) VALUES (?, ?, ?, NOW(), ?, ?)';
        $this->createQuery($sql, [$post->get('username'), password_hash($post->get('password'),PASSWORD_DEFAULT), $post->get('email'),  2, $activationcode ]);
        return $activationcode;
    }

    /**
     * get Users (for admin)
     *
     * @return void
     */
    public function getUsers()
    {
        $sql = "SELECT users.id, users.username, users.created_at, roles.role 
                FROM users 
                INNER JOIN roles ON users.role_id = roles.id 
                ORDER BY users.username ASC
                ";
        $result = $this->createQuery($sql);

        $users = [];
        foreach ($result as $row){
            $userId = $row['id'];
            $users[$userId] = new User($row);
        }
        $result->closeCursor();

        return $users;
    }

    /**
     * check if an user exist
     *
     * @param  array $post
     *
     * @return void
     */
    public function checkUser(Parameter $post)
    {
        $sql = 'SELECT COUNT(username) FROM users WHERE username = ?';
        $result = $this->createQuery($sql, [$post->get('username')]);
        $isUnique = $result->fetchColumn();// if TRUE already used name
        if($isUnique) {
            return '<p>Le pseudo existe déjà</p>';
        }
    }

    /**
     * chek user and PWD to login
     *
     * @param  array $post
     *
     * @return array
     */
    public function login(Parameter $post)
    {
        $sql = 'SELECT users.id, users.role_id, users.password, users.status, roles.role
                FROM users
                INNER JOIN roles ON roles.id = users.role_id
                WHERE username = ?';
        $data = $this->createQuery($sql, [$post->get('username')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
        $status = $result['status'];
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid,
            'status' => $status
        ];
    }

    /**
     * update user password
     *
     * @param  array $post
     * @param  string $pseudo
     *
     * @return void
     */
    public function updatePassword(Parameter $post, $pseudo)
    {
        $activationcode = md5($post->get('email').time());
        $sql = 'UPDATE users SET password = ?, status=0, activationcode=? WHERE username = ?';
        $this->createQuery($sql, [password_hash($post->get('password'), PASSWORD_DEFAULT), $activationcode, $pseudo]);
        return $activationcode;
    }

    /**
     * delete an user account
     *
     * @param  string $username
     *
     * @return void
     */
    public function deleteAccount($username)
    {
        $sql = 'DELETE FROM users WHERE username = ?';
        $this->createQuery($sql, [$username]);
    }

    /**
     * deleteUser
     *
     * @param  int $userId
     *
     * @return void
     */
    public function deleteUser($userId)
    {
        $sql = 'DELETE FROM users WHERE id = ?';
        $this->createQuery($sql, [$userId]);
    }

    public function confirmationEmail($code)
    {
        if(!empty($code) && isset($code) )
        {
            $sql = 'SELECT * FROM users WHERE activationcode= ?';
            $num = $this->createQuery($sql, [$code]);
            if($num>0)
            {
                $st=0;
                $result = 'SELECT id FROM users WHERE activationcode= ? and status= ?';
                $result4 = $this->createQuery($result, [$code, $st]); 
 
                if($result4>0) 
                {
                $st=1;
                $result1 = 'UPDATE users SET status= ? WHERE activationcode= ?';
                $this->createQuery($result1, [$st, $code]); 
                $mgs = "Votre compte est bien activé";
                return $mgs; 
                } else {
                    $mgs = "Votre compte a déjà été activé"; 
                return $mgs;
            }
            } else {
                $mgs = "Erreur d'activation";
                return  $mgs;
            }
        }   
    }



}