<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsAPI Articles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Latest News</h1>
        <div class="row">
            <?php
            require_once './Controller/NewsController.php';

            $items_por_pagina = 10;

            $pagina_actual = isset($_GET['page']) ? $_GET['page'] : 1;

            $newsController = new NewsController('a2cbfa558b684e9abe3ab195ee515ca3');

            $articles = $newsController->getArticles($pagina_actual, $items_por_pagina);

            foreach ($articles as $article) {
            ?>
                <div class="col-sm-3 mb-3 mb-sm-0 p-3">
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo ($article['urlToImage']) ?>" class="card-img-top" alt="<?php echo ($article['urlToImage']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo ($article['title']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo($article['author'])?></h6>
                            <p class="card-text"> <?php echo ($article['description']) ?> </p>
                            <a href="<?php echo($article['url'])?>" target="_blank" class="btn btn-primary">Show more</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                $total_paginas = ceil(count($newsController->getArticles()) / $items_por_pagina);

                for ($i = 1; $i <= $total_paginas; $i++) {
                ?>
                    <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
