<div class="p-0"> 
    <div class="d-flex justify-content-between align-items-center p-4 border-bottom bg-light bg-opacity-50">
        <div>
            <h4 class="fw-bold text-dark mb-0">Criar Nova Conta</h4>
            <small class="text-muted">Junte-se a nós para ofertas exclusivas.</small>
        </div>
    </div>

    <form wire:submit.prevent="register" class="p-4">
        <div class="row g-5">
            
            {{-- COLUNA ESQUERDA: DADOS PESSOAIS --}}
            <div class="col-lg-6 border-end-lg"> 
                <h6 class="text-warning fw-bold text-uppercase mb-4">Dados Pessoais</h6>

                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary small">Nome Completo</label>
                    <input type="text" wire:model="name" class="form-control form-control-lg fs-6 bg-light border-0">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary small">E-mail</label>
                    <input type="email" wire:model="email" class="form-control form-control-lg fs-6 bg-light border-0">
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary small">CPF</label>
                    <input type="text" 
                           wire:model="cpf" 
                           class="form-control form-control-lg fs-6 bg-light border-0" 
                           placeholder="000.000.000-00"
                           maxlength="14"
                           oninput="mascaraCPF(this)">
                    @error('cpf') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label fw-bold text-secondary small">Senha</label>
                        <input type="password" wire:model="password" class="form-control bg-light border-0">
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-secondary small">Confirmar</label>
                        <input type="password" wire:model="password_confirmation" class="form-control bg-light border-0">
                    </div>
                </div>
            </div>

            {{-- COLUNA DIREITA: ENDEREÇO --}}
            <div class="col-lg-6">
                <h6 class="text-warning fw-bold text-uppercase mb-4">Endereço</h6>

                {{-- RUA / LOGRADOURO (Agora no topo e com destaque) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold text-secondary small">Rua / Logradouro</label>
                    <input type="text" wire:model="endereco" class="form-control form-control-lg fs-6 bg-light border-0">
                    @error('endereco') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- LINHA: CEP (Simplificado) e NÚMERO --}}
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold text-secondary small">CEP</label>
                        {{-- Campo simples, sem input-group ou ícones --}}
                        <input type="text" 
                               wire:model="cep" 
                               class="form-control bg-light border-0" 
                               placeholder="00000-000"
                               maxlength="9"
                               oninput="mascaraCEP(this)">
                        @error('cep') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold text-secondary small">Número</label>
                        <input type="text" wire:model="numero" class="form-control bg-light border-0">
                        @error('numero') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-5">
                        <label class="form-label fw-bold text-secondary small">Bairro</label>
                        <input type="text" wire:model="bairro" class="form-control bg-light border-0">
                        @error('bairro') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold text-secondary small">Cidade</label>
                        <input type="text" wire:model="cidade" class="form-control bg-light border-0">
                        @error('cidade') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-bold text-secondary small">UF</label>
                        <select wire:model="estado" class="form-select bg-light border-0 p-1">
                            <option value="">-</option>
                            @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                                <option value="{{ $uf }}">{{ $uf }}</option>
                            @endforeach
                        </select>
                        @error('estado') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-bold text-secondary small">Complemento</label>
                    <input type="text" wire:model="complemento" class="form-control bg-light border-0">
                </div>
            </div>
        </div>

        <div class="mt-5 pt-3 border-top">
            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-dark text-uppercase shadow-sm">
                Finalizar Cadastro
            </button>
        </div>
    </form>
</div>