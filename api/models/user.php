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
        if ($query = Db::query("SELECT username, email, password FROM user WHERE username = :username OR email = :email", array(":email" => $email, ":username" => $email))) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                echo 'user'; //user doesn't exist
                exit;
            }
            if ($result['password'] == $password) {
                echo 'success'; //login successful
            } else {
                echo 'error'; //incorrect password
            }
        }
    }
}