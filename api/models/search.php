<?php
class Search {
    public function posts() {
        if ($data = json_decode(file_get_contents('php://input'))) {
            $search = "%$data->search%";
            if ($query = Db::query("SELECT id, title, body, author FROM posts WHERE title LIKE :search", array(":search" => $search))) {
                echo json_encode($query->fetchAll());
            }
        } else {
            echo "No post data supplied";
        }
    }
    public function users() {
        if ($data = json_decode(file_get_contents('php://input'))) {
            $search = "%$data->search%";
            if ($query = Db::query("SELECT username, id FROM user WHERE username LIKE :search", array(":search" => $search))) {
                echo json_encode($query->fetchAll());
            }
        } else {
            echo "No post data supplied";
        }
    }
}