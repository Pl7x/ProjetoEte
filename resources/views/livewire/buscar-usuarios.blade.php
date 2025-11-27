<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar usuários..." class="form-control mb-3">

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
                        <span class="badge text-success">Online</span> {{-- Alterado para text-green-500 --}}
                    @else
                        <span class="badge text-danger">Offline</span>
                        @if($user->last_activity)
                            <small class="text-muted">Última atividade: {{ $user->last_activity->diffForHumans() }}</small>
                        @else
                            <small class="text-muted">Nunca acessou</small>
                        @endif
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