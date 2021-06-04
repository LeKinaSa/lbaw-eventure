<li class="card">
    <div class="card-body px-3 py-2 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ $competitor->name }}</h5>
        @can ('update', $event)
        <button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
        @endcan
    </div>
</li>