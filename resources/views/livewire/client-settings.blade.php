<div>
    <div wire:ignore.self class="modal fade" id="clientSettingsModal" tabindex="-1" aria-labelledby="clientSettingsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="clientSettingsLabel">Minhas Configurações</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body px-4 py-4">
                    
                    @if (session()->has('message'))
                        <div class="alert alert-success rounded-3 mb-4">
                            <i class="bi bi-check-circle me-2"></i> {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="update">
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nome Completo <i class="bi bi-lock-fill"></i></label>
                                <input type="text" class="form-control bg-light" wire:model="name" readonly>
                            </div>
                            
                            {{-- CPF com Máscara Visual (Apenas leitura mas formatado) --}}
                            <div class="col-md-6">
                                <label class="form-label small text-muted">CPF <i class="bi bi-lock-fill"></i></label>
                                <input type="text" class="form-control bg-light" wire:model="cpf" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">Email <i class="bi bi-lock-fill"></i></label>
                                <input type="email" class="form-control bg-light" wire:model="email" readonly>
                            </div>
                            
                            {{-- TELEFONE COM MÁSCARA INTERATIVA --}}
                            <div class="col-md-6" x-data>
                                <label class="form-label small text-muted fw-bold text-dark">Telefone / WhatsApp</label>
                                <input type="text" class="form-control" 
                                    wire:model="phone" 
                                    placeholder="(00) 00000-0000"
                                    maxlength="15"
                                    x-on:input="
                                        let v = $el.value.replace(/\D/g,'');
                                        v = v.replace(/^(\d{2})(\d)/g,'($1) $2');
                                        v = v.replace(/(\d)(\d{4})$/,'$1-$2');
                                        $el.value = v;
                                    "
                                >
                                @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <h6 class="text-uppercase text-muted fw-bold small mb-3 border-top pt-3">Endereço de Entrega</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3" x-data>
                                <label class="form-label small text-muted">CEP</label>
                                <input type="text" class="form-control" 
                                    wire:model.live.debounce.500ms="cep" 
                                    placeholder="00000-000"
                                    maxlength="9"
                                    x-on:input="
                                        let v = $el.value.replace(/\D/g,'');
                                        v = v.replace(/^(\d{5})(\d)/,'$1-$2');
                                        $el.value = v;
                                    "
                                >
                                @error('cep') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Endereço</label>
                                <input type="text" class="form-control" wire:model="endereco">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small text-muted">Número</label>
                                <input type="text" class="form-control" wire:model="numero">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Bairro</label>
                                <input type="text" class="form-control" wire:model="bairro">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Cidade</label>
                                <input type="text" class="form-control" wire:model="cidade">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Estado</label>
                                <input type="text" class="form-control" wire:model="estado" maxlength="2">
                            </div>
                            <div class="col-12">
                                <label class="form-label small text-muted">Complemento</label>
                                <input type="text" class="form-control" wire:model="complemento">
                            </div>
                        </div>

                        <div class="bg-light p-4 rounded-3 mb-3 border">
                            <h6 class="text-uppercase text-danger fw-bold small mb-3">Alterar Senha</h6>
                            
                            <div class="row g-3">
                                {{-- Senha Atual --}}
                                <div class="col-md-12" x-data="{ show: false }">
                                    <label class="form-label small text-muted">Senha Atual</label>
                                    <div class="input-group">
                                        <input :type="show ? 'text' : 'password'" class="form-control border-end-0" wire:model="current_password">
                                        <button type="button" class="btn btn-white border border-start-0 text-muted" @click="show = !show">
                                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                        </button>
                                    </div>
                                    @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                {{-- Nova Senha --}}
                                <div class="col-md-6" x-data="{ show: false }">
                                    <label class="form-label small text-muted">Nova Senha</label>
                                    <div class="input-group">
                                        <input :type="show ? 'text' : 'password'" class="form-control border-end-0" wire:model="new_password">
                                        <button type="button" class="btn btn-white border border-start-0 text-muted" @click="show = !show">
                                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                        </button>
                                    </div>
                                    @error('new_password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                {{-- Confirmar Senha --}}
                                <div class="col-md-6" x-data="{ show: false }">
                                    <label class="form-label small text-muted">Confirmar Nova Senha</label>
                                    <div class="input-group">
                                        <input :type="show ? 'text' : 'password'" class="form-control border-end-0" wire:model="new_password_confirmation">
                                        <button type="button" class="btn btn-white border border-start-0 text-muted" @click="show = !show">
                                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                <span wire:loading.remove>Salvar Alterações</span>
                                <span wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script para fechar o modal --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal', (event) => {
                var myModalEl = document.getElementById('clientSettingsModal');
                var modal = bootstrap.Modal.getInstance(myModalEl);
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
</div>