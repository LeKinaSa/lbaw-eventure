<div class="card" style="max-width: 400px">
    <div class="card-body">
        <h5 class="card-title"><span class="text-primary">{{ $match->name_competitor1 }}</span> vs <span class="text-primary">{{ $match->name_competitor2 }}</span></h5>
        <p class="card-text"><b>Result: </b>
        @if ($match->result === 'Winner1')
            Win ({{ $match->name_competitor1 }})
        @elseif ($match->result === 'Winner2')
            Win ({{ $match->name_competitor2 }})
        @else
            {{ $match->result }}
        @endif
        </p>
        <p class="card-text text-muted">{{ $match->description }}</p>
    </div>
</div>