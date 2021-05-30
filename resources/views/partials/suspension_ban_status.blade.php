<p class="text-danger text-center mb-0" id="suspensionBanStatus">
@if (!is_null($suspension))
This user has been suspended until {{ (new DateTime($suspension->until))->format('j M, Y') }} for: {{ $suspension->reason }}
@elseif (!is_null($ban))
This user has been permanently banned for: <b>{{ $ban->reason }}</b>
@endif
</p>