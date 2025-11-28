@extends('layouts.app')
@section('title', ' - home')

@section('conteudo')

    {{-- 1. Hero Section Premium (Alinhado à Esquerda, Sem Countdown Fixo) --}}
    <section class="position-relative w-100 min-vh-100 d-flex align-items-center overflow-hidden text-white hero-section pb-5">
        {{-- Background Mais Dinâmico --}}
        <div class="position-absolute top-0 start-0 w-100 h-100"
             style="background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.2) 100%), url('https://images.unsplash.com/photo-1517963879433-6ad2b056d712?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
                     background-size: cover; background-position: center top; background-attachment: fixed;">
        </div>

        <div class="container position-relative z-2 pt-5">
            <div class="row align-items-center pt-lg-5">
                <div class="col-lg-7 animate-up">
                    {{-- Badge de Novidade (Mais sutil que o de urgência) --}}
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-4 rounded-pill bg-warning bg-opacity-25 border border-warning border-opacity-50 backdrop-blur">
                        <span class="badge bg-warning text-dark rounded-circle p-1"><i class="bi bi-lightning-fill"></i></span>
                        <span class="fw-bold text-warning text-uppercase tracking-wider small px-1">Nova Fórmula Elite Disponível</span>
                    </div>

                    <h1 class="display-2 fw-bolder mb-3 text-uppercase tracking-tighter lh-1">
                        Sua melhor versão <br>
                        <span class="text-transparent bg-clip-text bg-gradient-warning py-2">Exige o Máximo.</span>
                    </h1>
                    <p class="lead fw-normal mb-5 fs-5 text-white-50 pe-lg-5" style="max-width: 600px;">
                        Desenvolvemos a nutrição que atletas de alto nível usam para quebrar barreiras. Ciência pura, resultados reais, sem atalhos.
                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="{{ route('catalogo') }}" class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-bold text-dark shadow-lg hover-scale transform-gpu d-flex align-items-center justify-content-center gap-2">
                            EXPLORAR LOJA <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#ciencia" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold backdrop-blur hover-bg-white hover-text-dark transition-all">
                            NOSSA CIÊNCIA
                        </a>
                    </div>
                </div>
                 {{-- Espaço vazio na direita para deixar a imagem de fundo "respirar" --}}
                <div class="col-lg-5 d-none d-lg-block"></div>
            </div>
        </div>

        {{-- Scroll Down Sutil --}}
        <a href="#beneficios" class="position-absolute bottom-0 start-50 translate-middle-x mb-5 text-white-50 text-decoration-none animate-bounce d-none d-md-block">
            <small class="text-uppercase tracking-widest">Scroll para descobrir</small>
            <div class="mt-2"><i class="bi bi-chevron-down fs-4"></i></div>
        </a>
    </section>

    {{-- 2. Benefícios (Overlap - Sobrepondo o Hero para profundidade) --}}
    <section class="position-relative z-3 mt-n5 pt-5" id="beneficios">
        <div class="container">
             <div class="row g-4 justify-content-center">
                @foreach([
                    ['icon' => 'box-seam', 'title' => 'Entrega Rápida', 'desc' => 'Envio prioritário para todo Brasil.'],
                    ['icon' => 'bi bi-shield-check', 'title' => 'Pureza Garantida', 'desc' => 'Matéria-prima importada e laudos.'],
                    ['icon' => 'award-fill', 'title' => 'Formulações Elite', 'desc' => 'Doses efetivas baseadas em ciência.'],
                    ['icon' => 'whatsapp', 'title' => 'Consultoria Grátis', 'desc' => 'Tire dúvidas antes de comprar.']
                ] as $item)
                <div class="col-md-6 col-lg-3 animate-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                    <div class="card h-100 border-0 bg-white shadow hover-lift p-4 rounded-4 text-center text-lg-start d-block d-lg-flex align-items-center gap-3">
                        <div class="icon-box flex-shrink-0 bg-dark text-warning rounded-circle mb-3 mb-lg-0 mx-auto mx-lg-0 d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                            <i class="bi bi-{{ $item['icon'] }} fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">{{ $item['title'] }}</h5>
                            <p class="text-muted small mb-0 lh-sm">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

     {{-- 3. Trust Bar (Marcas) --}}
     <div class="py-5">
        <div class="container">
            <p class="text-center text-muted small text-uppercase fw-bold mb-4 tracking-widest">Parceiros Oficiais e Certificações</p>
            <div class="row row-cols-3 row-cols-md-6 g-4 justify-content-center align-items-center opacity-25 grayscale-hover transition-all">
                {{-- Logos Placeholder (Use imagens reais aqui) --}}
                @for($i=0; $i<6; $i++)
                <div class="col text-center">
                     <img src="https://placehold.co/120x50/e9ecef/adb5bd?text=LOGO+{{$i+1}}" alt="Parceiro" class="img-fluid mix-blend-multiply">
                </div>
                @endfor
            </div>
        </div>
    </div>


    {{-- 4. NOVA SEÇÃO: Autoridade e Ciência (Split Screen) --}}
    <section class="py-5 bg-light overflow-hidden" id="ciencia">
        <div class="container py-lg-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 order-2 order-lg-1">
                    <span class="text-warning fw-bold text-uppercase tracking-widest small"><i class="bi bi-hexagon-fill me-1"></i> Engenharia Nutricional</span>
                    <h2 class="display-5 fw-bold mb-4 text-dark">Não é milagre.<br>É <span class="text-primary">Ciência</span> aplicada.</h2>
                    <p class="lead text-muted mb-4">Fugimos do "marketing de rótulo". Cada ingrediente em nossos produtos tem uma razão clínica para estar lá, na dosagem exata que seu corpo precisa para responder ao estímulo.</p>

                    <ul class="list-unstyled vstack gap-3 mb-5">
                        <li class="d-flex gap-3">
                            <i class="bi bi-check-circle-fill text-success fs-4 flex-shrink-0"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Zero Aditivos Ocultos</h6>
                                <small class="text-muted">Sem "blends proprietários". Você sabe exatamente o que está tomando.</small>
                            </div>
                        </li>
                         <li class="d-flex gap-3">
                            <i class="bi bi-check-circle-fill text-success fs-4 flex-shrink-0"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Matéria-Prima Premium</h6>
                                <small class="text-muted">Whey importado (Glina/Arla) e Creapure® como padrão.</small>
                            </div>
                        </li>
                    </ul>
                    
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    {{-- Container principal, agora com flex-column para empilhar os elementos --}}
                    <div class="position-relative d-flex flex-column align-items-center">

                        {{-- Elemento decorativo de fundo --}}
                        <div class="position-absolute top-50 start-50 translate-middle bg-warning opacity-10 rounded-circle"
                             style="width: 80%; padding-bottom: 80%; z-index: -1;"></div>

                        {{-- A imagem principal --}}
                        {{-- Adicionamos 'mb-4' para dar espaço entre a imagem e o card --}}
                        <img src="{{ asset('img/laudo.jpg') }}"
                             alt="Pesquisa e Desenvolvimento"
                             class="img-fluid rounded-4 shadow-lg hover-scale-img transition-transform mb-4"
                             style="max-width: 60%;">

                        {{-- Card Flutuante --}}
                        {{-- Removemos 'position-absolute', 'bottom-0', 'start-0', 'm-4' --}}
                        {{-- Adicionamos 'position-relative' para o efeito de bounce e ajustamos a margem --}}
                        <div class="bg-white p-3 rounded-3 shadow-sm d-flex align-items-center gap-3 animate-bounce-slow position-relative"
                             style="z-index: 1; margin-top: 0rem;"> {{-- Margem negativa para sobrepor levemente a imagem --}}
                            <i class="bi bi-shield-fill-check text-primary fs-2"></i>
                            <div>
                                <h6 class="fw-bold mb-0">Laudos Aprovados</h6>
                                <small class="text-success fw-bold">100% de pureza verificada</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    

    {{-- 7. Prova Social (Mudança para fundo escuro para contraste) --}}
    <section class="py-5 bg-dark text-white overflow-hidden position-relative">
         {{-- Background texture --}}
         <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="container position-relative z-1 py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6">A escolha de quem não aceita o básico.</h2>
            </div>
            <div class="row g-4">
                @foreach([
                    ['text' => 'Já usei diversas marcas importadas, mas a pureza do Whey de vocês é inigualável. A recuperação pós-treino mudou da água pro vinho.', 'name' => 'Carlos M.', 'city' => 'Crossfit Athlete'],
                    ['text' => 'O pré-treino não me dá aquela taquicardia ruim, apenas foco limpo e energia constante. Bati meus PRs em 3 semanas de uso.', 'name' => 'Fernanda L.', 'city' => 'Personal Trainer'],
                    ['text' => 'Entrega absurda de rápida para o Nordeste. Chegou tudo lacrado, com laudo, impecável. Ganharam um cliente fiel.', 'name' => 'Ricardo S.', 'city' => 'Recife, PE']
                ] as $testimonial)
                <div class="col-md-4">
                    <div class="card border-0 p-4 shadow-lg rounded-4 h-100 bg-white bg-opacity-10 backdrop-blur text-white">
                        <div class="d-flex gap-1 text-warning mb-3">
                            @for($s=0;$s<5;$s++) <i class="bi bi-star-fill"></i> @endfor
                        </div>
                        <p class="fst-italic opacity-75 mb-4">"{{ $testimonial['text'] }}"</p>
                        <div class="d-flex align-items-center gap-3 mt-auto">
                             {{-- Avatar com iniciais --}}
                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px;">
                                {{ substr($testimonial['name'], 0, 1) }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ $testimonial['name'] }}</h6>
                                <small class="opacity-50">{{ $testimonial['city'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    

    {{-- WhatsApp Flutuante (Mantido) --}}
    <a href="#" class="position-fixed bottom-0 end-0 m-4 btn btn-success rounded-circle shadow-lg d-flex align-items-center justify-content-center z-3 hover-scale"
       style="width: 60px; height: 60px;" target="_blank">
        <i class="bi bi-whatsapp fs-2"></i>
    </a>

@endsection

@push('styles')
<style>

    /* --- NOVOS ESTILOS --- */
    /* Ajuste para o Hero ficar atrás dos cards de benefícios */
    .hero-section { z-index: 1; }
    /* Margem negativa para criar o efeito de overlap */
    .mt-n5 { margin-top: -5rem !important; }

    /* Animação lenta para o card flutuante na seção de ciência */
    @keyframes bounceSlow { 0%, 100% {transform: translateY(0);} 50% {transform: translateY(-15px);} }
    .animate-bounce-slow { animation: bounceSlow 4s ease-in-out infinite; }

    /* --- ESTILOS MANTIDOS/AJUSTADOS DO ORIGINAL --- */
    .bg-gradient-warning { background: linear-gradient(45deg, #ffc107, #ffdb4d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .bg-gradient-to-t { background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 30%); } /* Ajustei o gradiente para ser menos agressivo */
    .backdrop-blur { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
    .tracking-tighter { letter-spacing: -2px; }
    .tracking-wider { letter-spacing: 1px; }
    .tracking-widest { letter-spacing: 2px; }
    .aspect-square { aspect-ratio: 1/1; }
    .min-h-300 { min-height: 300px; }

    /* Animações */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes bounce { 0%, 20%, 50%, 80%, 100% {transform: translateY(0);} 40% {transform: translateY(-10px);} 60% {transform: translateY(-5px);} }

    .animate-up { animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; } /* Adicionado opacity 0 inicial */
    .animate-bounce { animation: bounce 2s infinite; }

    /* Interações */
    .hover-scale { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
    .hover-scale:hover { transform: scale(1.05); }

    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important; } /* Sombra mais suave e elevação maior */

    .hover-zoom img { transition: transform 0.7s ease; }
    .hover-zoom:hover img { transform: scale(1.08); } /* Zoom mais sutil */

    /* Product Card Complex Hovers */
    .product-card:hover .action-buttons { transform: translateX(0); opacity: 1; }
    .product-card:hover .add-btn { transform: translateY(0); }
    .product-card:hover .hover-scale-img { transform: scale(1.05); }
    .product-card .add-btn { z-index: 3; }

    /* Grayscale para logos */
    .grayscale-hover { filter: grayscale(100%); mix-blend-mode: multiply; } /* Adicionado mix-blend para melhor integração com fundo branco */
    .grayscale-hover:hover { filter: grayscale(0%); opacity: 1 !important; }

    /* Botões */
    .btn-white { background: white; border: 1px solid #eee; color: #333; }
    .btn-white:hover { background: #f8f9fa; color: var(--bs-danger); border-color: var(--bs-danger); }
</style>
@endpush