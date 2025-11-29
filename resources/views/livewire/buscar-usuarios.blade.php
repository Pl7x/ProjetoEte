<div class="container-fluid px-0">

    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center my-4">
        <h4 class="mb-0">Gerenciar Usuários</h4>
        <a href="{{ route('usuarios.novo') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Novo Usuário
        </a>
    </div>

    {{-- Barra de Pesquisa --}}
    <div class="card mb-4 border-0 shadow-sm bg-light">
        <div class="card-body py-3">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Buscar por nome ou e-mail..." 
                    wire:model.live.debounce.300ms="search">
            </div>
        </div>
    </div>

    {{-- Mensagens --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabela --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white fw-bold py-3">
            <i class="fas fa-users me-1 text-primary"></i> Lista de Usuários
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Nome</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold">E-mail</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold text-center">Status</th>
                            <th scope="col" class="py-3 text-secondary text-uppercase small fw-bold" style="min-width: 150px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-dark">
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->isOnline())
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Online</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">Offline</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Botão Editar --}}
                                    <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                        <i class="fas fa-edit me-2"></i> Editar
                                    </a>
                                    
                                    {{-- Botão Excluir --}}
                                    @if(auth()->id() !== $user->id)
                                        <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                            wire:click="confirmDelete({{ $user->id }})">
                                            <i class="fas fa-trash-alt me-2"></i> Excluir
                                        </button>
                                    @else
                                        <span class="text-muted small ms-2">(Você)</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                Nenhum usuário encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end py-3 border-top-0">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    {{-- Modal de Exclusão --}}
    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o usuário <strong>{{ $userNameToDelete }}</strong>?</p>
                    <p class="text-danger small mb-0">Esta ação é irreversível.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteUser" wire:loading.attr="disabled">
                        Excluir Usuário
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-delete-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
                myModal.show();
            });

            Livewire.on('hide-delete-modal', () => {
                var el = document.getElementById('deleteUserModal');
                var myModal = bootstrap.Modal.getInstance(el);
                if (myModal) myModal.hide();
            });
        });
    </script>
    @endpush
</div>