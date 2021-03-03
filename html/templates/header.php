<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><? isset($pageTitle) ? $pageTitle : "Eventure"?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous" defer></script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="homepage.php">EVENTURE</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        </form>
                        <div class="col d-flex justify-content-end">
                            <a href="sign_in.php" role="button" class="btn btn-outline-light m-1">Sign in</a>
                            <a href="sign_up.php" role="button" class="btn btn-outline-light m-1">Sign up</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>