<div>
    <div class="flex justify-between mb-4">
        <input type="text" placeholder="Buscar usuários..." wire:model.debounce.500ms="searchTerm" class="input input-bordered w-full mr-4" />
    </div>

    <table class="table w-full table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Criação</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($user->isOnline())
                        <span class="badge badge-success">Online</span>
                    @else
                        <span class="badge badge-secondary">Offline</span>
                        <small class="text-muted">Última atividade: {{ $user->last_activity->diffForHumans() }}</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>