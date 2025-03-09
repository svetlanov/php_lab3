<?php

/**
 * Получает список изображений из указанной директории.
 *
 * @param string $directory Путь к папке с изображениями.
 * @return array Массив имен файлов изображений.
 */
function getImagesFromDirectory(string $directory): array {
    // Проверяем, существует ли папка
    if (!is_dir($directory)) {
        return [];
    }

    // Получаем список файлов
    $files = scandir($directory);

    // Фильтруем только файлы .jpg и .jpeg
    return array_filter($files, function($file) use ($directory) {
        return is_file($directory . $file) && preg_match('/\.(jpg)$/i', $file);
    });
}

$dir = '../image/';

// Получаем список изображений
$images = getImagesFromDirectory($dir);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея изображений</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        header, footer {
            padding: 10px;
            background-color: #222;
            color: white;
            margin-bottom: 20px;
        }
        nav {
            margin: 10px;
        }
        nav a {
            text-decoration: none;
            color: white;
            margin: 0 15px;
            font-weight: bold;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }
        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .gallery img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

<header>
    <h1>Галерея картинок</h1>
    <nav>
        <a href="#">About Dogs</a> | 
        <a href="#">News</a> | 
        <a href="#">Contacts</a>
    </nav>
</header>

<div class="gallery">
    <?php
    // Вывод изображений в галерею
    foreach ($images as $image) {
        echo "<img src='$dir$image' alt='Dog Image $image'>";
    }
    ?>
</div>

<footer>
    <p>USM © 2025</p>
</footer>

</body>
</html>
