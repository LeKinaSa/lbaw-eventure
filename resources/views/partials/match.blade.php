<div class="card" style="max-width: 400px">
    <div class="card-body">
        <h5 class="card-title"><span class="text-primary">{{ $competitor1->name }}</span> vs <span class="text-primary">{{ $competitor2->name }}</span></h5>
        <p class="card-text"><b>Result:</b>{{ $match->result }}</p>
        <p class="card-text text-muted">{{ $match->description }}</p>
    </div>
</div>