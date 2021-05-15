<div class="card" style="max-width: 400px">
    <div class="card-body">
        <h5 class="card-title"><span class="text-primary">{{ $match->id_competitor1 }}</span> vs <span class="text-primary">{{ $match->id_competitor2 }}</span></h5>
        <p class="card-text"><b>Result:</b>{{ $match->result }}</p>
        <p class="card-text text-muted">{{ $match->description }}</p>
    </div>
</div>