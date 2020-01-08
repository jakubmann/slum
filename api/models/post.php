<?php
class Post {
    public function scroll() {
        $data = json_decode(file_get_contents('php://input'));
        $count = $data->count;
        $previous = $data->previous;
        $posts = array();

        if ($query = Db::query('SELECT posts.title, posts.body, posts.id, posts.author, posts.postdate, user.username as author_name
            FROM posts
            INNER JOIN user ON user.id = posts.author
            ORDER BY posts.postdate DESC
            LIMIT :previous, :count',
            array(":previous" => $previous, ":count" => $count)
        )) {
            echo json_encode($query->fetchAll());
        }   
    }

    public function preview() {
        if ($query = Db::query('SELECT id, title, body, postdate
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
        if ($query = Db::query("INSERT INTO posts(author, title, body) VALUES (:author, :title, :body)",
        array(":author" => $_SESSION['user_id'],
            ":title" => $title,
            ":body" => $body
        ))) {
            echo "success";
        }
    }

    public function id($id) {
        if ($query = Db::query(
            'SELECT posts.id, posts.author, posts.title, posts.body, posts.postdate, user.username AS author_name
            FROM posts
            INNER JOIN user ON user.id = posts.author
            WHERE posts.id = :id', 
            array(":id" => $id)
        )) {
            echo json_encode($query->fetch(PDO::FETCH_ASSOC));
        } 
    }
}