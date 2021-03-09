<?php
    include_once('../templates/header.php');
?>

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-md-8">
            <img src="../assets/chess.jpg" class="img-fluid" alt="An image">
            <h1 class="display-4 text-center p-3">
                Helping you organize and participate in all the events you dream of
            </h1>
        </div>
        <div class="col-md-4 text-center p-3">
            <h5>Top Events this Week</h5>
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title"><a class="text-primary" href="event.php">Magic: the Gathering Tournament</a></h5>
                    <div class="row align-items-center h-100">
                        <div class="col-md-6">
                            <img class="card-img-bottom" src="../assets/tibalt.jpg"> 
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">
                                27/02/2021<br>Rua da Vida, nº33<br>134 participants
                            </p>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title"><a class="text-primary" href="event.php">Amateur Blitz Chess Tournament</a></h5>
                    <div class="row align-items-center h-100">
                        <div class="col-md-6">
                            <img class="card-img-bottom" src="../assets/chess_event.jpg"> 
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">
                                01/03/2021<br>Rua das Tulipas, nº154<br>122 participants
                            </p>                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title"><a class="text-primary" href="event.php">Starcraft 2 Invitational</a></h5>
                    <div class="row align-items-center h-100">
                        <div class="col-md-6">
                            <img class="card-img-bottom" src="../assets/starcraft2.jpg"> 
                        </div>
                        <div class="col-md-6">
                            <p class="card-text">
                                04/03/2021<br>Rua do Castelo, nº1<br>152 participants
                            </p>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include_once('../templates/footer.php');
?>