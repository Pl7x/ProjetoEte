@extends('layouts.app')
@section('title', ' - Trocas')
@section('conteudo')

<div class="container py-5">
    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Política de Trocas e Devoluções</h1>
        <p class="text-muted lead w-75 mx-auto">
            Queremos que você esteja totalmente satisfeito com sua compra. Confira abaixo nossas regras, prazos e procedimentos.
        </p>
    </div>

    <div class="row justify-content-center">

        {{-- Coluna Centralizada --}}
        <div class="col-lg-8">

            {{-- Seção de Dúvidas (Accordion) --}}
            <h4 class="fw-bold mb-4"><i class="bi bi-info-circle me-2 text-warning"></i>Regras e Dúvidas Frequentes</h4>

            <div class="accordion shadow-sm" id="accordionTrocas">

                {{-- Item 1: Prazo de Arrependimento --}}
                <div class="accordion-item border-0 mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            1. Qual o prazo para desistência da compra?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionTrocas">
                        <div class="accordion-body text-muted">
                            Conforme o Código de Defesa do Consumidor, você tem até <strong>7 (sete) dias corridos</strong> após o recebimento do produto para solicitar a devolução por arrependimento. O produto deve estar em sua embalagem original, sem indícios de uso e com o lacre intacto.
                        </div>
                    </div>
                </div>

                {{-- Item 2: Produto com Defeito --}}
                <div class="accordion-item border-0 mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            2. Recebi um produto com defeito, e agora?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionTrocas">
                        <div class="accordion-body text-muted">
                            Caso identifique algum defeito de fabricação ou violação na embalagem, entre em contato conosco em até <strong>30 dias corridos</strong>. Faremos a análise e, constatado o defeito, providenciaremos a troca sem custos adicionais.
                        </div>
                    </div>
                </div>

                {{-- Item 3: Reembolso --}}
                <div class="accordion-item border-0 mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            3. Como funciona o reembolso?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionTrocas">
                        <div class="accordion-body text-muted">
                            Após o recebimento e conferência do produto em nosso centro de distribuição, o reembolso será realizado na mesma forma de pagamento do pedido:
                            <ul class="mt-2 mb-0">
                                <li><strong>Cartão de Crédito:</strong> Estorno na fatura (pode levar até 2 faturas).</li>
                                <li><strong>PIX ou Boleto:</strong> Transferência em conta corrente em até 5 dias úteis.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Item 4: Troca por outro produto --}}
                <div class="accordion-item border-0 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                            4. Posso trocar por outro sabor ou produto?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionTrocas">
                        <div class="accordion-body text-muted">
                            Sim. A primeira troca é grátis. Caso opte por um produto de valor diferente, a diferença será cobrada ou um vale-compras será gerado.
                        </div>
                    </div>
                </div>

            </div>

            {{-- Rodapé de Ajuda --}}
            <div class="mt-5 text-center pt-4 border-top">
                <p class="text-muted small mb-2">Ainda ficou com alguma dúvida sobre o processo?</p>
                <a href="#" class="text-decoration-none fw-bold text-success fs-5">
                    <i class="bi bi-whatsapp me-1"></i> Falar com Atendente
                </a>
            </div>

        </div>
    </div>
</div>

@endsection

