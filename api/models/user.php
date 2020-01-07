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
            if ($result['password'] == $password) {
                echo 'success'; //login successful
                $_SESSION['user_id'] = $result['id'];
            } else {
                echo 'error'; //incorrect password
            }
        }
    }

    public function logout() {
        session_destroy();
    }

    public function get() {
        if ($query = Db::query("SELECT * FROM user WHERE id = :id", array(":id" => $_SESSION['user_id']))) {
            echo json_encode($query->fetch(PDO::FETCH_ASSOC));
        }
    }
}