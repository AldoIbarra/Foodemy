<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href= <?= $stylename ?> >
    <title><?= $titlename ?></title>
</head>
<body>
    <nav class="back-eerie">
        <h1 class="title poppy">Foodemy</h1>
        <button id="category-button">
            <h4 class="baby option">Cursos</h4>
            <img src="../resources/dropdown.svg" alt="">
        </button>
        <div id="searchBarContainer">
            <button>
                <img src="../resources/magnifying-glass-white.svg" alt="">
            </button>
            <input type="text" name="search-bar" id="search-bar" placeholder="Busca algún curso...">
        </div>
        <button class="red-button">
            Ingresar
        </button>
    </nav>