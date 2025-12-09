<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientSettings extends Component
{
    // Dados Pessoais
    public $name;
    public $email;
    public $cpf; 
    public $phone;
    
    // Endereço
    public $cep;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;

    // Senha
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::guard('client')->user();
        
        if ($user) {
            $this->fill($user->only([
                'name', 'email', 'cep', 'endereco', 'numero', 
                'complemento', 'bairro', 'cidade', 'estado'
            ]));

            // Formata o CPF visualmente para exibir (000.000.000-00)
            $this->cpf = $this->mask($user->cpf, '###.###.###-##');
            
            // Formata o Telefone visualmente
            $this->phone = $this->formatPhone($user->phone);
        }
    }

    public function update()
    {
        $user = Auth::guard('client')->user();

        // Limpa a máscara do telefone para validação correta (deixa só números)
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        $this->phone = $cleanPhone; // Atualiza a propriedade para validar

        $rules = [
            'phone' => 'required|string|min:10|max:11', // Valida tamanho real
            'cep' => 'nullable|string|max:9',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
        ];

        if (!empty($this->new_password)) {
            $rules['current_password'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('A senha atual está incorreta.');
                }
            }];
            $rules['new_password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

        $dataToUpdate = [
            'phone' => $cleanPhone, // Salva limpo no banco
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
        ];

        if (!empty($this->new_password)) {
            $dataToUpdate['password'] = Hash::make($this->new_password);
        }

        $user->update($dataToUpdate);

        // Reaplica a máscara no telefone para o usuário ver formatado após salvar
        $this->phone = $this->formatPhone($cleanPhone);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('message', 'Dados atualizados com sucesso!');
        
        $this->dispatch('close-modal'); 
    }

    public function updatedCep($value)
    {
        if (strlen($value) >= 8) {
            $cep = preg_replace('/[^0-9]/', '', $value);
            $url = "https://viacep.com.br/ws/{$cep}/json/";
            $data = @json_decode(file_get_contents($url), true);
            
            if ($data && !isset($data['erro'])) {
                $this->endereco = $data['logradouro'];
                $this->bairro = $data['bairro'];
                $this->cidade = $data['localidade'];
                $this->estado = $data['uf'];
            }
        }
    }

    // --- Helpers de Máscara (PHP) ---
    private function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    private function formatPhone($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $len = strlen($phone);
        if($len == 11) return $this->mask($phone, '(##) #####-####');
        if($len == 10) return $this->mask($phone, '(##) ####-####');
        return $phone;
    }

    public function render()
    {
        return view('livewire.client-settings');
    }
}