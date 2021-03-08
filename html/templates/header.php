<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><? echo isset($pageTitle) ? $pageTitle : "Eventure"?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous" defer></script>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="homepage.php">EVENTURE</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse mt-3 mt-md-0" id="navbarContent">
                        <div class="col d-flex flex-column flex-md-row justify-content-end gap-2">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Search" aria-label="Search" required>
                                    <button type="submit" class="btn btn-outline-light"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                            <a href="sign_in.php" role="button" class="btn btn-outline-light">Sign in</a>
                            <a href="sign_up.php" role="button" class="btn btn-outline-light">Sign up</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>