<?php

class user {
    public function login() {
        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email;
        $password = $data->password;
        if (!$data) {
            echo 'No post data supplied';
            exit;
        }
        if ($query = Db::query("SELECT id, username, email, password FROM user WHERE username = :username OR email = :email", array(":email" => $email, ":username" => $email))) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                echo 'user'; //user doesn't exist
                exit;
            }
            if (password_verify($password, $result['password'])) {
                echo 'success'; //login successful
                $_SESSION['user_id'] = $result['id'];
            } else {
                echo 'error'; //incorrect password
            }
        }
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            echo 'No post data supplied';
            exit;
        }

        if ($query = Db::query("SELECT email FROM user WHERE email = :email", array(":email" => $data->email))) {
            if ($query->rowCount() > 0) {
                echo 'email';
                exit;
            }
        }

        if ($query = Db::query("SELECT username FROM user WHERE username = :username", array(":username" => $data->username))) {
            if ($query->rowCount() > 0) {
                echo 'user';
                exit;
            }
        }

        $password = password_hash($data->password, PASSWORD_DEFAULT);
        if ($query = Db::query("INSERT INTO user (username, email, password, regdate) VALUES (:username, :email, :password, CURRENT_TIMESTAMP)",
        array(":username" => $data->username, ":email" => $data->email, ":password" => $password))) {
            echo "success";
        }
    }


    public function logout() {
        session_destroy();
    }

    public function get() {
        if ($query = Db::query("SELECT id, username, regdate FROM user WHERE id = :id", array(":id" => $_SESSION['user_id']))) {
            echo json_encode($query->fetch(PDO::FETCH_ASSOC));
        }
    }
}