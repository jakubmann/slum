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
}