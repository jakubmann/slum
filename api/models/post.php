<?php
class Post {
    public function scroll() {
        $data = json_decode(file_get_contents('php://input'));
        $count = $data->count;
        $previous = $data->previous;
        $posts = array();

        if ($query = Db::query('SELECT title, body, id, author, post_date
            FROM posts
            ORDER BY post_date DESC
            LIMIT :previous, :count',
            array(":previous" => $previous, ":count" => $count)
        )) {
            echo json_encode($query->fetchAll());
        }   
    }

    public function preview() {
        if ($query = Db::query('SELECT id, title, body, post_date
            FROM posts
            ORDER BY post_date DESC
            LIMIT 40'
        )) {
            echo json_encode($query->fetchAll());
        } 
    }

    public function submit() {
        $data = json_decode(file_get_contents('php://input'));
        $title = $data->title;
        $body = $data->body;
        if ($query = Db::query("INSERT INTO posts(author, title, body, post_date) VALUES (:author, :title, :body, CURRENT_TIMESTAMP)",
        array(":author" => $_SESSION['user_id'],
            ":title" => $title,
            ":body" => $body
        ))) {
            echo "success";
        }
    }

    public function id($id) {
        if ($query = Db::query(
            'SELECT posts.id, posts.author, posts.title, posts.body, posts.post_date, user.username
            FROM posts
            INNER JOIN user ON user.id = posts.author', 
            array(":id" => $id)
        )) {
            echo json_encode($query->fetchAll());
        } 
    }
}