<div class="card">
    <div class="card-header">
        <h4>{{ __('user.title') }}</h4>
    </div>
    <table class="table table-dark table-striped m-0">
        <thead>
        <tr>
            <th>{{ __('user.id') }}</th>
            <th>{{ __('common.branch') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($role->users as $user)
        <tr>
            <td><h6>{{ $user->name }}</h6></td>
            <td>{{ $user->branch->name }}</td>
            <td class="text-center">
                <a href="{{ route('user.edit', [$user]) }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-info"></i>
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card-footer"></div>
</div>