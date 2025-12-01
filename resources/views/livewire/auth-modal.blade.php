<div>
    @if($showRegister)
        {{-- 
            =============================================
            MODO REGISTRO (GRANDE / HORIZONTAL)
            =============================================
            Aqui usamos uma div larga (w-100) com fundo branco.
        --}}
        <div class="bg-white rounded-4 shadow-lg overflow-hidden position-relative w-100">
            {{-- Botão Fechar --}}
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
            
            <livewire:client-register />
            
            <div class="text-center py-3 bg-light bg-opacity-50 border-top">
                <button wire:click="toggleMode" class="btn btn-link text-decoration-none text-muted fw-bold small">
                    <i class="bi bi-arrow-left me-1"></i> Já tenho conta? Voltar para Login
                </button>
            </div>
        </div>
    @else
        {{-- 
            =============================================
            MODO LOGIN (PEQUENO / COMPACTO)
            =============================================
            Aqui usamos o Grid do Bootstrap para centralizar e restringir a largura.
            O fundo branco fica APENAS na coluna central (col-md-5).
        --}}
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4"> {{-- Define o tamanho da caixa de login --}}
                
                <div class="bg-white rounded-4 shadow-lg overflow-hidden position-relative">
                    {{-- Botão Fechar --}}
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    <livewire:client-login />
                </div>

            </div>
        </div>
    @endif
</div>