<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ClientLogin extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

public function login()
    {
        $this->validate();

        if (Auth::guard('client')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // --- LÓGICA DE MERGE (SESSÃO -> BANCO) ---
            $sessionCart = session()->get('cart', []);
            $clientId = Auth::guard('client')->id();

            if (!empty($sessionCart)) {
                foreach ($sessionCart as $productId => $item) {
                    $dbItem = \App\Models\CartItem::where('client_id', $clientId)
                        ->where('product_id', $productId)
                        ->first();

                    if ($dbItem) {
                        // Se já existe no banco, soma a quantidade
                        $dbItem->quantity += $item['quantity'];
                        $dbItem->save();
                    } else {
                        // Se não existe, cria novo
                        \App\Models\CartItem::create([
                            'client_id' => $clientId,
                            'product_id' => $productId,
                            'quantity' => $item['quantity']
                        ]);
                    }
                }
                // Limpa a sessão, pois agora o "verdadeiro" carrinho está no banco
                session()->forget('cart');
            }
            // ------------------------------------------

            return redirect(request()->header('Referer'));
        }

        $this->addError('email', 'E-mail ou senha incorretos.');
    }

    public function logout()
    {
        Auth::guard('client')->logout(); // Logout específico do cliente
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.client-login');
    }
}