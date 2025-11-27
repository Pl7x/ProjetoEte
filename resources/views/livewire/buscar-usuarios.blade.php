<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    <input type="text" placeholder="Buscar usuários..." wire:model.debounce.500ms="searchTerm" class="input input-bordered w-full mb-4" />
    <table class="table w-full">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Criação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>

</div>
