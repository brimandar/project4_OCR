<?php

namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\User;

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
        $sql = 'INSERT INTO users (username, password, created_at, role_id) VALUES (?, ?, NOW(), ?)';
        $this->createQuery($sql, [$post->get('username'), password_hash($post->get('password'),PASSWORD_DEFAULT), 2 ]);
    }

    /**
     * get Users (for admin)
     *
     * @return void
     */
    public function getUsers()
    {
        $sql = 'SELECT users.id, users.username, users.created_at, roles.role 
                FROM users 
                INNER JOIN roles ON users.role_id = roles.id 
                ORDER BY users.id DESC';
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
        $sql = 'SELECT users.id, users.role_id, users.password, roles.role
                FROM users
                INNER JOIN roles ON roles.id = users.role_id
                WHERE username = ?';
        $data = $this->createQuery($sql, [$post->get('username')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid
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
        $sql = 'UPDATE users SET password = ? WHERE username = ?';
        $this->createQuery($sql, [password_hash($post->get('password'), PASSWORD_DEFAULT), $pseudo]);
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
}