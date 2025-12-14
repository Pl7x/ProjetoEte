@extends('layouts.app')
@section('title', ' - Politicas')
@section('conteudo')

<div class="container py-5">
    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5">Política de Privacidade</h1>
        <p class="text-muted lead w-75 mx-auto">
            A sua segurança é nossa prioridade. Entenda de forma clara como coletamos, usamos e protegemos os seus dados.
        </p>
    </div>

    <div class="row justify-content-center">

        {{-- Coluna Centralizada --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm bg-light mb-4">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-shield-lock-fill text-success display-4 mb-3"></i>
                    <p class="text-muted mb-0">
                        Comprometemo-nos a proteger sua privacidade e seus dados pessoais. Todas as informações são tratadas de acordo com a <strong>Lei Geral de Proteção de Dados (LGPD)</strong>.
                    </p>
                </div>
            </div>

            {{-- Seção de Tópicos (Accordion) --}}
            <h4 class="fw-bold mb-4 mt-5"><i class="bi bi-file-earmark-lock me-2 text-warning"></i>Termos e Condições de Uso</h4>

            <div class="accordion shadow-sm" id="accordionPrivacidade">

                {{-- Item 1: Coleta de Dados --}}
                <div class="accordion-item border-0 mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            1. Quais dados nós coletamos?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionPrivacidade">
                        <div class="accordion-body text-muted">
                            <p>Coletamos informações essenciais para oferecer nossos serviços e melhorar sua experiência:</p>
                            <ul class="mb-0">
                                <li><strong>Dados Pessoais:</strong> Nome, CPF, e-mail, telefone e endereço (para entrega e faturamento).</li>
                                <li><strong>Dados de Navegação:</strong> Endereço IP, tipo de dispositivo, navegador e páginas acessadas (para análise de desempenho).</li>
                                <li><strong>Dados de Pagamento:</strong> Informações de cartão são processadas diretamente pelo gateway de pagamento e não ficam salvas integralmente em nossos servidores.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Item 2: Uso das Informações --}}
                <div class="accordion-item border-0 mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            2. Como usamos seus dados?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionPrivacidade">
                        <div class="accordion-body text-muted">
                            <p>Utilizamos seus dados estritamente para:</p>
                            <ul class="mb-0">
                                <li>Processar e entregar seus pedidos.</li>
                                <li>Enviar atualizações sobre o status da compra.</li>
                                <li>Prestar suporte ao cliente e resolver dúvidas.</li>
                                <li>Enviar promoções e novidades (somente se você autorizar na inscrição).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Item 3: Cookies --}}
                <div class="accordion-item border-0 mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            3. Política de Cookies
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionPrivacidade">
                        <div class="accordion-body text-muted">
                            Utilizamos cookies para personalizar sua navegação e lembrar suas preferências (como itens no carrinho). Você pode gerenciar ou bloquear os cookies nas configurações do seu navegador a qualquer momento, porém algumas funcionalidades do site podem ser afetadas.
                        </div>
                    </div>
                </div>

                {{-- Item 4: Compartilhamento --}}
                <div class="accordion-item border-0 mb-3 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                            4. Compartilhamento com Terceiros
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionPrivacidade">
                        <div class="accordion-body text-muted">
                            Não vendemos seus dados. Compartilhamos informações apenas com parceiros essenciais para a operação, como:
                            <ul class="mt-2 mb-0">
                                <li>Transportadoras (para entrega do pedido).</li>
                                <li>Plataformas de pagamento (para processar a transação).</li>
                                <li>Ferramentas de e-mail marketing (se inscrito na newsletter).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                 {{-- Item 5: Seus Direitos --}}
                 <div class="accordion-item border-0 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button fw-bold collapsed bg-light text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                            5. Seus Direitos (LGPD)
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionPrivacidade">
                        <div class="accordion-body text-muted">
                            Você tem total controle sobre seus dados. A qualquer momento, você pode solicitar:
                            <ul class="mt-2 mb-0">
                                <li>A confirmação da existência de tratamento de dados.</li>
                                <li>O acesso aos dados que possuímos sobre você.</li>
                                <li>A correção de dados incompletos ou desatualizados.</li>
                                <li>A exclusão definitiva dos seus dados de nossa base (exceto quando a lei exigir o armazenamento).</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Rodapé de Ajuda / DPO --}}
            <div class="mt-5 text-center pt-4 border-top">
                <p class="text-muted small mb-2">Para assuntos relacionados à privacidade e dados (DPO), entre em contato:</p>
                <a href="mailto:privacidade@suppstore.com" class="text-decoration-none fw-bold text-dark fs-5">
                    <i class="bi bi-envelope me-1"></i> suppstore@gmail.com
                </a>
            </div>

        </div>
    </div>
</div>

@endsection


