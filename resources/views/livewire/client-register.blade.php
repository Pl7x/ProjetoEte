<div class="p-3">
    <div class="text-center mb-4">
        <h4 class="fw-bold">Criar Conta</h4>
        <p class="text-muted small">Preencha seus dados completos.</p>
    </div>

    <form wire:submit.prevent="register">
        
        {{-- DADOS PESSOAIS --}}
        <h6 class="text-warning fw-bold small mb-2 border-bottom pb-1">Dados Pessoais</h6>
        
        <div class="mb-2">
            <label class="form-label small fw-bold mb-0">Nome Completo</label>
            <input type="text" wire:model="name" class="form-control form-control-sm @error('name') is-invalid @enderror">
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="row g-2 mb-2">
            <div class="col-7">
                <label class="form-label small fw-bold mb-0">E-mail</label>
                <input type="email" wire:model="email" class="form-control form-control-sm @error('email') is-invalid @enderror">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-5">
                <label class="form-label small fw-bold mb-0">CPF</label>
                {{-- MÁSCARA CPF --}}
                <input type="text" 
                       wire:model="cpf" 
                       class="form-control form-control-sm @error('cpf') is-invalid @enderror" 
                       placeholder="000.000.000-00"
                       maxlength="14"
                       onkeyup="mascaraCPF(this)">
                @error('cpf') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label small fw-bold mb-0">Senha</label>
                <input type="password" wire:model="password" class="form-control form-control-sm @error('password') is-invalid @enderror">
                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold mb-0">Confirmar</label>
                <input type="password" wire:model="password_confirmation" class="form-control form-control-sm">
            </div>
        </div>

        {{-- ENDEREÇO --}}
        <h6 class="text-warning fw-bold small mb-2 border-bottom pb-1 mt-3">Endereço</h6>

        <div class="row g-2 mb-2">
            {{-- CEP MAIS APARENTE --}}
            <div class="col-5"> {{-- Aumentei um pouco a coluna --}}
                <label class="form-label small fw-bold mb-0">CEP</label>
                <div class="input-group input-group-sm">
                    {{-- Ícone com fundo amarelo para destacar --}}
                    <span class="input-group-text bg-warning text-dark fw-bold border-end-0">
                        <i class="bi bi-geo-alt-fill"></i>
                    </span>
                    <input type="text" 
                           wire:model="cep" 
                           class="form-control form-control-sm border-start-0 @error('cep') is-invalid @enderror" 
                           placeholder="00000-000"
                           maxlength="9"
                           onkeyup="mascaraCEP(this)">
                </div>
                @error('cep') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>

            <div class="col-7">
                <label class="form-label small fw-bold mb-0">Rua/Logradouro</label>
                <input type="text" wire:model="endereco" class="form-control form-control-sm @error('endereco') is-invalid @enderror">
                @error('endereco') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row g-2 mb-2">
            <div class="col-4">
                <label class="form-label small fw-bold mb-0">Número</label>
                <input type="text" wire:model="numero" class="form-control form-control-sm @error('numero') is-invalid @enderror">
                @error('numero') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-8">
                <label class="form-label small fw-bold mb-0">Bairro</label>
                <input type="text" wire:model="bairro" class="form-control form-control-sm @error('bairro') is-invalid @enderror">
                @error('bairro') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row g-2 mb-2">
            <div class="col-8">
                <label class="form-label small fw-bold mb-0">Cidade</label>
                <input type="text" wire:model="cidade" class="form-control form-control-sm @error('cidade') is-invalid @enderror">
                @error('cidade') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-4">
                <label class="form-label small fw-bold mb-0">UF</label>
                <select wire:model="estado" class="form-select form-select-sm @error('estado') is-invalid @enderror">
                    <option value="">--</option>
                    <option value="AC">AC</option> <option value="AL">AL</option> <option value="AP">AP</option>
                    <option value="AM">AM</option> <option value="BA">BA</option> <option value="CE">CE</option>
                    <option value="DF">DF</option> <option value="ES">ES</option> <option value="GO">GO</option>
                    <option value="MA">MA</option> <option value="MT">MT</option> <option value="MS">MS</option>
                    <option value="MG">MG</option> <option value="PA">PA</option> <option value="PB">PB</option>
                    <option value="PR">PR</option> <option value="PE">PE</option> <option value="PI">PI</option>
                    <option value="RJ">RJ</option> <option value="RN">RN</option> <option value="RS">RS</option>
                    <option value="RO">RO</option> <option value="RR">RR</option> <option value="SC">SC</option>
                    <option value="SP">SP</option> <option value="SE">SE</option> <option value="TO">TO</option>
                </select>
                @error('estado') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold mb-0">Complemento (Opcional)</label>
            <input type="text" wire:model="complemento" class="form-control form-control-sm">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-warning fw-bold text-dark">
                <span wire:loading.remove>Finalizar Cadastro</span>
                <span wire:loading class="spinner-border spinner-border-sm"></span>
            </button>
        </div>
    </form>
</div>

{{-- 
    IMPORTANTE: Este script deve estar presente no arquivo. 
    Sem ele, o 'onkeyup' não encontrará a função.
--}}
<script>
    function mascaraCPF(i) {
        let v = i.value;
        v = v.replace(/\D/g, ""); // Remove tudo que não é dígito
        v = v.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca ponto entre o 3º e o 4º
        v = v.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca ponto entre o 6º e o 7º
        v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Coloca traço entre o 9º e o 10º
        i.value = v;
        i.dispatchEvent(new Event('input')); // Avisa o Livewire que mudou
    }

    function mascaraCEP(i) {
        let v = i.value;
        v = v.replace(/\D/g, ""); // Remove tudo que não é dígito
        v = v.replace(/^(\d{5})(\d)/, "$1-$2"); // Coloca traço após o 5º dígito
        i.value = v;
        i.dispatchEvent(new Event('input')); // Avisa o Livewire que mudou
    }
</script>