<div>
    @if($showRegister)
        {{-- TELA DE REGISTRO --}}
        <livewire:client-register />
        
        <div class="text-center pb-3">
            <button wire:click="toggleMode" class="btn btn-link text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Login
            </button>
        </div>
    @else
        {{-- TELA DE LOGIN --}}
        <livewire:client-login />
        
        @guest 
        <div class="text-center border-top pt-3 pb-3 mx-3 mt-2">
            <p class="small mb-2 text-muted">Ainda não tem conta?</p>
            <button wire:click="toggleMode" class="btn btn-outline-dark btn-sm w-100">
                Criar nova conta
            </button>
        </div>
        @endguest
    @endif
</div>