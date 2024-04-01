<?php

/**
 * Format Class
 */
class Format
{
    public function formatDate($date)
    {
        return date('F j, Y, g:i a', strtotime($date));
    }

    public function textShorten($text, $limit = 200)
    {
        if (strlen($text) <= $limit) {
            return $text;
        }
        $text = $text . " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' ')); // đẩm bảo không cắt giữa 1 từ
        $text = $text . " ...";
        return $text;
    }

    public function validation($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // public function validKeepSpecialChars($data)
    // {
    //     $data = trim($data);
    //     $data = stripcslashes($data);
    //     $data = htmlspecialchars($data);
    //     return $data;
    // }

    public function title()
    {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');
        //$title = str_replace('_', ' ', $title);
        if ($title == 'index') {
            $title = 'home';
        } elseif ($title == 'contact') {
            $title = 'contact';
        }
        return $title = ucfirst($title);
    }
}
