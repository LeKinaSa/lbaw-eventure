<p class="text-danger text-center mb-0" id="suspensionBanStatus">
@if (!is_null($ban))
This user has been permanently banned for: <b>{{ $ban->reason }}</b>
@elseif (!is_null($suspension))
This user has been suspended until <b>{{ (new DateTime($suspension->until))->format('j M, Y') }}</b> for: <b>{{ $suspension->reason }}</b>
@endif
</p>