<div class="container py-5">
    <h2>Meu Carrinho</h2>

    @if($items->isEmpty())
        <div class="alert alert-info">
            Seu carrinho está vazio. <a href="{{ route('catalogo') }}">Ir às compras</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Qtd</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($item->product->image_path)
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                             alt="{{ $item->product->name }}"
                                             style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                    @endif
                                    <span>{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td>R$ {{ number_format($item->product->price, 2, ',', '.') }}</td>
                            <td>
                                <button wire:click="decrement({{ $item->id }})" class="btn btn-sm btn-outline-secondary">-</button>
                                <span class="mx-2">{{ $item->quantity }}</span>
                                <button wire:click="increment({{ $item->id }})" class="btn btn-sm btn-outline-secondary">+</button>
                            </td>
                            <td>R$ {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}</td>
                            <td>
                                <button wire:click="remove({{ $item->id }})" class="btn btn-sm btn-danger">
                                    Remover
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <h4>Total: R$ {{ number_format($total, 2, ',', '.') }}</h4>
        </div>

        <div class="d-flex justify-content-end mt-2">
            <button class="btn btn-success btn-lg">Finalizar Compra</button>
        </div>
    @endif
</div>
