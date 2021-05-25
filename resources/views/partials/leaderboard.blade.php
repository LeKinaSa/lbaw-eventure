@if (!is_null($leaderboard))
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
        @foreach($leaderboard as $competitor)
            <tr>
                <td>{{ $competitor['position'] }}</td>
                <td>{{ $competitor['name'] }}</td>
                <td>{{ $competitor['games'] }}</td>
                <td>{{ $competitor['wins'] }}</td>
                <td>{{ $competitor['draws'] }}</td>
                <td>{{ $competitor['losses'] }}</td>
                <td>{{ $competitor['points'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif