<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $user->name }}</h5>
        <h6 class="text-primary"><a href="{{ route('users.profile', ['username' => $user->username]) }}">&commat;{{ $user->username }}</a></h6>
    </div>
</div>
