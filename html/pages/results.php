<? include_once('../templates/header.php'); ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="event.php">Amateur Blitz Chess Tournament</a></li>
            <li class="breadcrumb-item active" aria-current="page">Results</li>
        </ol>
    </nav>

    <h1 class="text-center mb-4">Results</h1>

    <section id="matches" class="mb-3">
        <header class="d-flex gap-2 justify-content-between align-items-center mb-2">
            <h4>Matches</h4>

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#matchModal" aria-label="Add match">
                    <i class="fa fa-plus"></i>
                </button>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlayers" aria-expanded="false" aria-controls="collapsePlayers" aria-label="Players">
                    <i class='fa fa-users'></i>
                </button>
                <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings" aria-label="Settings">
                    <i class="fa fa-wrench"></i>
                </button>
            </div>

            <div class="modal fade" id="matchModal" tabindex="-1" aria-labelledby="matchModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="matchModalLabel">Add match</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="first" class="h5 form-label">First *</label>
                                        <select class="form-select" name="first" required>
                                            <option selected>Dmitri Dolyakov</option>
                                            <option>Martin Fowler</option>
                                            <option>Jane Caldwin</option>
                                            <option>Santiago Neves</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="second" class="h5 form-label">Second *</label>
                                        <select class="form-select" name="second" required>
                                            <option>Dmitri Dolyakov</option>
                                            <option selected>Martin Fowler</option>
                                            <option>Jane Caldwin</option>
                                            <option>Santiago Neves</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5>Result *</h5>
                                    <div class="d-flex justify-content-evenly">
                                        <div class="form-check">
                                            <label class="form-check-label" for="futureMatch">Future match</label>
                                            <input class="form-check-input" type="radio" name="result" id="futureMatch" checked required>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="resultWinFirst">1st Win</label>
                                            <input class="form-check-input" type="radio" name="result" id="resultWinFirst">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="resultDraw">Draw</label>
                                            <input class="form-check-input" type="radio" name="result" id="resultDraw">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="resultWinSecond">2nd Win</label>
                                            <input class="form-check-input" type="radio" name="result" id="resultWinSecond">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="matchDate" class="h5 form-label">Date</label>
                                    <input type="date" class="form-control" id="matchDate" name="matchDate">
                                </div>

                                <div class="mb-3">
                                    <label for="matchTime" class="h5 form-label">Time</label>
                                    <input type="time" class="form-control" id="matchTime" name="matchTime">
                                </div>

                                <div class="mb-3">
                                    <label for="information" class="h5 form-label">Additional information</label>
                                    <textarea class="form-control" id="information" name="information"></textarea>
                                </div>

                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" value="Add">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="collapse mb-2 bg-light" id="collapsePlayers">
            <div class="p-3">
                <h5>Players / Teams</h5>
                <ul class="list-unstyled d-flex flex-column gap-1">
                    <li class="input-group">
                        <input type="text" class="form-control" value="Dmitri Dolyakov">
                        <button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                    </li>
                    <li class="input-group">
                        <input type="text" class="form-control" value="Martin Fowler">
                        <button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                    </li>
                    <li class="input-group">
                        <input type="text" class="form-control" value="Jane Caldwin">
                        <button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                    </li>
                    <li class="input-group">
                        <input type="text" class="form-control" value="Santiago Neves">
                        <button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                    </li>
                </ul>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Name" aria-label="Name">
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>

        <div class="collapse mb-2 bg-light" id="collapseSettings">
            <form class="p-3">
                <h5>Points</h5>
                <div class="d-inline-flex flex-column flex-md-row mb-3 gap-2">
                    <div class="input-group">
                        <span class="input-group-text" id="winPointsLabel">Win</span>
                        <input type="number" class="form-control" aria-label="Win" aria-describedby="winPointsLabel" name="winPoints" min="0" max="100" step="0.1" value="1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="drawPointsLabel">Draw</span>
                        <input type="number" class="form-control" aria-label="Draw" aria-describedby="drawPointsLabel" name="drawPoints" min="0" max="100" step="0.1" value="0.5">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="lossPointsLabel">Loss</span>
                        <input type="number" class="form-control" aria-label="Loss" aria-describedby="lossPointsLabel" name="lossPoints" min="0" max="100" step="0.1" value="0">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <label for="generateLeaderboard" class="form-check-label">Generate leaderboard</label>
                    <input type="checkbox" class="form-check-input" id="generateLeaderboard" name="generateLeaderboard" checked>
                </div>

                <input type="submit" class="btn btn-primary" value="Apply">
            </form>
        </div>

        <div class="d-inline-flex flex-column flex-md-row flex-md-wrap gap-2">
            <div class="card" style="max-width: 400px">
                <div class="card-body">
                    <h5 class="card-title"><span class="text-primary">Dmitri Dolyakov</span> vs <span class="text-primary">Martin Fowler</span></h5>
                    <p class="card-text"><b>Result:</b> Win (Dmitri Dolyakov)</p>
                    <p class="card-text text-muted">Dolyakov wins with the white pieces after Fowler resigns</p>
                </div>
            </div>
            <div class="card" style="max-width: 400px">
                <div class="card-body">
                    <h5 class="card-title"><span class="text-primary">Dmitri Dolyakov</span> vs <span class="text-primary">Jane Caldwin</span></h5>
                    <p class="card-text"><b>Result:</b> Draw</p>
                    <p class="card-text text-muted">Draw by threefold repetition</p>
                </div>
            </div>
            <div class="card" style="max-width: 400px">
                <div class="card-body">
                    <h5 class="card-title"><span class="text-primary">Dmitri Dolyakov</span> vs <span class="text-primary">Santiago Neves</span></h5>
                    <p class="card-text"><b>Result:</b> Win (Dmitri Dolyakov)</p>
                    <p class="card-text text-muted">Decisive victory for Dolyakov with the black pieces</p>
                </div>
            </div>
            <div class="card" style="max-width: 400px">
                <div class="card-body">
                    <h5 class="card-title"><span class="text-primary">Martin Fowler</span> vs <span class="text-primary">Santiago Neves</span></h5>
                    <p class="card-text"><b>Result:</b> Win (Martin Fowler)</p>
                </div>
            </div>
            <div class="card" style="max-width: 400px">
                <div class="card-body">
                    <h5 class="card-title"><span class="text-primary">Martin Fowler</span> vs <span class="text-primary">Jane Caldwin</span></h5>
                    <p class="card-text"><b>Result:</b> Win (Martin Fowler)</p>
                    <p class="card-text text-muted">Surprising victory from Fowler, who was the lower rated player</p>
                </div>
            </div>
            <div class="card" style="max-width: 400px">
                <div class="card-body">
                    <h5 class="card-title"><span class="text-primary">Santiago Neves</span> vs <span class="text-primary">Jane Caldwin</span></h5>
                    <p class="card-text"><b>Result:</b> Win (Jane Caldwin)</p>
                </div>
            </div>
        </div>
    </section>

    <section id="leaderboard">
        <h4>Leaderboard</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Position</th>
                        <th>Name</th>
                        <th>Games</th>
                        <th>Wins</th>
                        <th>Draws</th>
                        <th>Losses</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dmitri Dolyakov</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td>0</td>
                        <td>2.5</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Martin Fowler</td>
                        <td>3</td>
                        <td>2</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Jane Caldwin</td>
                        <td>3</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1.5</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Santiago Neves</td>
                        <td>3</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>

<? include_once('../templates/footer.php'); ?>