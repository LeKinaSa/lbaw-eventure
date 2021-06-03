<div class="card" style="max-width: 400px">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title"><span class="text-primary">{{ $match->name_competitor1 }}</span> vs <span class="text-primary">{{ $match->name_competitor2 }}</span></h5>
        <div class="d-flex flex-grow-1 flex-column justify-content-between">
            <div>
                <p class="card-text mb-0"><b>Result: </b>
                @if ($match->result === 'Winner1')
                    Win ({{ $match->name_competitor1 }})
                @elseif ($match->result === 'Winner2')
                    Win ({{ $match->name_competitor2 }})
                @else
                    {{ $match->result }}
                @endif
                </p>
                @if (!is_null($match->date))
                <p class="card-text"><b>Date: </b> {{ (new DateTime($match->date))->format('j M, Y H:i') }}</p>
                @endif
            </div>
            <p class="card-text text-muted">{{ $match->description }}</p>
        </div>
    </div>
</div>