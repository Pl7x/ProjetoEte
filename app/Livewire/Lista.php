<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Importe o trait para paginação
use App\Models\Product; // Importe o modelo Product (ou Produto, se for o caso)
use Illuminate\View\View; // Importe View para o tipo de retorno

class Lista extends Component
{
    use WithPagination; // Use o trait para habilitar a paginação

    // Opcional: Se quiser uma barra de busca, pode adicionar aqui:
    // public $search = '';

    // PROPRIEDADES PARA O MODAL DE EXCLUSÃO
    // Armazena o ID do produto a ser excluído quando o modal é aberto
    public $productIdToDelete;
    // Armazena o nome do produto a ser excluído para exibir no modal
    public $productToDeleteName;

    /**
     * Prepara os dados do produto para a exclusão e exibe o modal de confirmação.
     *
     * @param int $productId O ID do produto a ser excluído.
     * @return void
     */
    public function confirmDelete($productId)
    {
        $this->productIdToDelete = $productId; // Guarda o ID do produto
        $product = Product::findOrFail($productId); // Busca o produto para obter o nome
        $this->productToDeleteName = $product->name; // Guarda o nome do produto

        // Emite um evento para o JavaScript na view abrir o modal de exclusão
        // O JS deve ter um listener para 'show-delete-modal'
        $this->dispatch('show-delete-modal');
    }

    /**
     * Efetiva a exclusão do produto após a confirmação no modal.
     *
     * @return void
     */
    public function deleteProduct()
    {
        // Verifica se há um ID de produto para excluir
        if ($this->productIdToDelete) {
            Product::destroy($this->productIdToDelete); // Exclui o produto do banco de dados

            // Define uma mensagem de sucesso que será exibida na próxima renderização
            session()->flash('error', 'Produto excluído com sucesso!');

            // Reinicia a paginação para a primeira página. Isso é útil se o item excluído
            // era o último de uma página, evitando uma página vazia.
            $this->resetPage();

            // Esconde o modal de exclusão através de um evento JavaScript
            // O JS deve ter um listener para 'hide-delete-modal'
            $this->dispatch('hide-delete-modal');

            // Limpa as propriedades do modal para evitar dados residuais
            $this->productIdToDelete = null;
            $this->productToDeleteName = null;
        } else {
            // Se, por algum motivo, o ID do produto não estiver definido, exibe um erro
            session()->flash('error', 'Erro ao tentar excluir o produto: ID não fornecido.');
        }
    }

    /**
     * Renderiza a view do componente, passando os dados necessários.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        // Busca os produtos do banco de dados.
        // - with('category'): Carrega a relação de categoria para cada produto,
        //   evitando o problema de N+1 queries ao acessar $produto->category->name.
        // - orderBy('name', 'asc'): Ordena os produtos por nome em ordem ascendente.
        // - paginate(10): Pagina os resultados, mostrando 10 produtos por página.
        $produtos = Product::with('category')
                            // Opcional: Adicione a lógica de busca se tiver um `$this->search`
                            // ->when($this->search, function($query) {
                            //     $query->where('name', 'like', '%' . $this->search . '%');
                            // })
                            ->orderBy('name', 'asc')
                            ->paginate(10);

        // Retorna a view 'livewire.lista' e passa a coleção paginada de produtos para ela.
        return view('livewire.lista', [
            'produtos' => $produtos,
        ]);
    }
}