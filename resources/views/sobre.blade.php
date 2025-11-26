@extends('layouts.app')
@section('title', ' - Home')
@section('conteudo')

{{-- Hero Section (Banner Principal) --}}
    <section class="position-relative overflow-hidden text-center text-white bg-dark py-5">
        {{-- Background com Overlay: Focado em produtos/potes e não em pesos de academia --}}
        <div class="position-absolute top-0 start-0 w-100 h-100"
             style="background-image: url('https://images.unsplash.com/photo-1593095948071-474c5cc2989d?q=80&w=1920&auto=format&fit=crop'); background-size: cover; background-position: center; filter: brightness(0.3);">
        </div>

        <div class="container position-relative z-1 py-5">
            <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold ls-1 shadow-sm">DESDE 2015</span>
            <h1 class="display-3 fw-bold mb-3 text-uppercase">Força & Integridade</h1>
            <p class="lead text-white-50 mx-auto mb-4" style="max-width: 700px;">
                Especialistas em nutrição esportiva. Entregamos a suplementação que você precisa, onde você estiver.
            </p>
        </div>
    </section>

    {{-- Nossa História & Estatísticas --}}
    <div class="container my-5 py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative pe-lg-4">
                    <div class="ratio ratio-4x3 rounded-3 overflow-hidden shadow-lg border border-4 border-white">
                        {{-- Imagem de Estoque/Logística em vez de academia --}}
                        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Centro de Distribuição SuppStore"
                             class="object-fit-cover">
                    </div>
                    {{-- Badge Flutuante --}}
                    <div class="position-absolute bottom-0 end-0 bg-dark text-white p-4 rounded-3 shadow-lg me-n3 mb-n3 d-none d-md-block border-start border-warning border-5">
                        <p class="mb-0 small text-uppercase text-warning fw-bold">Pedidos Enviados</p>
                        <h3 class="fw-bold mb-0">500.000+</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h6 class="text-warning fw-bold text-uppercase ls-1 mb-3">Quem Somos</h6>
                <h2 class="fw-bold mb-4 display-6">O maior estoque de resultados do Brasil.</h2>
                <p class="text-muted mb-4 lead fs-6">
                    A <strong>SuppStore</strong> é uma referência em e-commerce de suplementos. Nascemos para acabar com a dúvida na hora de comprar: aqui você encontra as melhores marcas globais com garantia de procedência.
                </p>
                <p class="text-muted mb-4">
                    Nossa operação conta com um centro de distribuição climatizado e automatizado, garantindo que seu Whey, Creatina ou Pré-treino saia da prateleira e chegue à sua casa em tempo recorde e em perfeitas condições.
                </p>

                <div class="row g-4 mt-2">
                    <div class="col-6">
                        <h3 class="fw-bold text-dark mb-0">100%</h3>
                        <p class="text-muted small">Nota Fiscal em Tudo</p>
                    </div>
                    <div class="col-6">
                        <h3 class="fw-bold text-dark mb-0">24h</h3>
                        <p class="text-muted small">Despacho Imediato</p>
                    </div>
                    <div class="col-6">
                        <h3 class="fw-bold text-dark mb-0">Original</h3>
                        <p class="text-muted small">Garantia de Fábrica</p>
                    </div>
                    <div class="col-6">
                        <h3 class="fw-bold text-dark mb-0">15+</h3>
                        <p class="text-muted small">Marcas Parceiras</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Nossos Pilares (Cards) --}}
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h3 class="fw-bold">Nossos Pilares</h3>
                <div class="bg-warning mx-auto mt-2" style="width: 60px; height: 3px;"></div>
            </div>
            <div class="row g-4">
                {{-- Card 1 --}}
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-up bg-white text-center">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3">
                            <i class="bi bi-box-seam fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Logística Premium</h5>
                        <p class="text-muted small mb-0">
                            Armazenamento correto longe de umidade e calor, garantindo a integridade dos nutrientes até a entrega.
                        </p>
                    </div>
                </div>
                {{-- Card 2 --}}
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-up bg-white text-center">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3">
                            <i class="bi bi-shield-check fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Procedência Garantida</h5>
                        <p class="text-muted small mb-0">
                            Sem falsificações. Compramos lotes diretamente da indústria e distribuidores oficiais das marcas.
                        </p>
                    </div>
                </div>
                {{-- Card 3 --}}
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-up bg-white text-center">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3">
                            <i class="bi bi-headset fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Consultoria Especializada</h5>
                        <p class="text-muted small mb-0">
                            Dúvidas sobre qual proteína escolher? Nosso time de atendimento entende de suplementação.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Time de Especialistas --}}
    <section class="container my-5 py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
            <div>
                <h3 class="fw-bold mb-1">Quem faz acontecer</h3>
                <p class="text-muted mb-0">Liderança focada em excelência operacional</p>
            </div>
           
        </div>

        <div class="row g-4">
            {{-- Membro 1 --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="card-img-top rounded-3 mb-3 shadow-sm object-fit-cover" style="height: 350px;" alt="CEO">
                    <h5 class="fw-bold mb-0">Roberto Silva</h5>
                    <small class="text-warning fw-bold text-uppercase">Diretor Executivo</small>
                </div>
            </div>
            {{-- Membro 2 --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="card-img-top rounded-3 mb-3 shadow-sm object-fit-cover" style="height: 350px;" alt="Nutricionista">
                    <h5 class="fw-bold mb-0">Dra. Amanda Costa</h5>
                    <small class="text-warning fw-bold text-uppercase">Resp. Técnica</small>
                </div>
            </div>
            {{-- Membro 3 --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="card-img-top rounded-3 mb-3 shadow-sm object-fit-cover" style="height: 350px;" alt="Logística">
                    <h5 class="fw-bold mb-0">Carlos Mendes</h5>
                    <small class="text-warning fw-bold text-uppercase">Gerente de Estoque</small>
                </div>
            </div>
            {{-- Membro 4 --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 text-center">
                    {{-- Nova imagem para Júlia Pereira --}}
                    <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="card-img-top rounded-3 mb-3 shadow-sm object-fit-cover" style="height: 350px;" alt="Atendimento">
                    <h5 class="fw-bold mb-0">Júlia Pereira</h5>
                    <small class="text-warning fw-bold text-uppercase">Vendas Online</small>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ - Perguntas Frequentes --}}
    <section class="bg-white py-5">
        <div class="container max-w-800">
            <h3 class="fw-bold text-center mb-5">Dúvidas Frequentes</h3>

            <div class="accordion accordion-flush" id="faqAccordion">
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Os produtos são originais?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Absolutamente. Compramos diretamente dos fabricantes ou distribuidores oficiais no Brasil. Emitimos Nota Fiscal em todas as vendas.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Qual o prazo de entrega?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            O prazo varia conforme sua região. Para capitais do Sudeste, a média é de 1 a 2 dias úteis após a aprovação do pagamento.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bottom">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Vocês possuem loja física?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Atualmente operamos 100% online através do nosso Centro de Distribuição em São Paulo, o que nos permite oferecer preços mais competitivos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @push('styles')
    <style>
        .hover-up {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-up:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .ls-1 {
            letter-spacing: 2px;
        }
        .icon-box {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .max-w-800 {
            max-width: 800px;
            margin: 0 auto;
        }
        .accordion-button:not(.collapsed) {
            color: var(--primary-color);
            background-color: transparent;
            box-shadow: none;
        }
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }
    </style>
    @endpush

@endsection
