<?php
    session_start();
    define('JEKYLL_ROOT', $_SERVER['DOCUMENT_ROOT']."/admin/jekyll-cms/");
    set_time_limit (3600);

    $filepath=$_POST['filepath'];

    $path_parts = pathinfo($filepath);
    $filename = $_POST['title'].'-'.date_timestamp_get($date).'.md';

    $markdown = fopen($path_parts['dirname']."/".$filename, "w");

    fwrite($markdown, "---\n");
    foreach($_POST as $key => $value){
        if((strcmp($key,'filepath')!=0) && (strcmp($key,'content')!=0)){
            fwrite($markdown, $key.": ".$value."\n");
        }
    }

    if(isset($_FILES["image"])){
        move_uploaded_file($_FILES["image"]["tmp_name"],
        JEKYLL_ROOT."assets/img/".$_FILES["image"]["name"]);
        $image_path = "assets/img/".$_FILES["image"]["name"];

        fwrite($markdown, "image: ".$image_path."\n");
    }

    fwrite($markdown, "---\n\n");

    if(isset($_POST['content'])){
        fwrite($markdown, $_POST['content']);
    }

    fclose($markdown);

    $_SESSION['dirty']=true;
?>
