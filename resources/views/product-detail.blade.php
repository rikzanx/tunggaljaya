<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $product->name }} - {{ $company->name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset($company->image_company) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($company->image_company) }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
<!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="https://api.whatsapp.com/send/?phone={{ $company->telp }}&text=Halo%20{{ $company->name }}">{{ $company->telp }}</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->


    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-success logo h3 align-self-center" href="{{ route('index') }}">
                {{ $company->name }}
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">Tentang kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('product') }}">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Header -->

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>



    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="{{ asset($product->images[0]->image_product) }}" alt="Card image cap" id="product-detail">
                    </div>
                    <div class="row">
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-dark fas fa-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </div>
                        <!--End Controls-->
                        <!--Start Carousel Wrapper-->
                        <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                            <!--Start Slides-->
                            <div class="carousel-inner product-links-wap" role="listbox">
                                <div class="carousel-item active">
                                    <div class="row">
                                    @foreach ($product->images as $image)
                                        @if($loop->index!=0 && $loop->index%3==0)
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="row">
                                        @endif
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid" src="{{ asset($image->image_product) }}" alt="Product Image 1">
                                            </a>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--End Slides-->
                        </div>
                        <!--End Carousel Wrapper-->
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-dark fas fa-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2">{{ $product->name }}</h1>
                            
                            <h6>Description:</h6>
                            <p>{{$product->description}}</p>

                            {{-- <h6>Specification</h6> --}}
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Brand:</h6>
                                    <p class="text-muted"><strong>{{ $product->brand }}</strong></p>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Size:</h6>
                                    <p class="text-muted"><strong>{{ $product->size }} inch</strong></p>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Material:</h6>
                                    <p class="text-muted"><strong>Cast Iron, Cast Steel / WCB / A216, Forged Steel / A105, Stainless Steel / SS304 / 316 / CF8 / CF8M, Bronze / Brass, PVC / U-PVC.</strong></p>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Rating:</h6>
                                    <p class="text-muted"><strong>ANSI 150 / 300 / 600 / 900<br>PN 10 / 16 / 40 / 63<br>JIS 10K / 16K / 20K</strong></p>
                                </li>
                            </ul>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Connection:</h6>
                                    <p class="text-muted"><strong>{{ $product->connection }}</strong></p>
                                </li>
                            </ul>
                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <a class="btn btn-success btn-lg" name="submit" value="buy" href="{{ route('contact') }}">Hubungi Kami</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    <!-- Start Article -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Related Products</h4>
            </div>

            <!--Start Carousel Wrapper-->
            <div id="carousel-related-product">
                @foreach ($products as $product)    
                <div class="p-2 pb-3">
                    <div class="product-wap card rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="{{ asset($product->images[0]->image_product) }}">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled">
                                    <li><a class="btn btn-success text-white mt-2" href="{{ route('product-detail',[$product->slug]) }}"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('product-detail',[$product->slug]) }}" class="h3 text-decoration-none"><b>{{ $product->name }}</b></a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li>Material: {{ $product->material }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>


        </div>
    </section>
    <!-- End Article -->


    <!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row">

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo">{{ $company->name }}</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            {{ $company->address }}
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none" href="https://api.whatsapp.com/send/?phone={{ $company->telp }}&text=Halo%20{{ $company->name }}">{{ $company->telp }}</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none" href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Produk</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        @foreach ($products_footer as $product)
                        <li><a class="text-decoration-none" href="{{ route('product-detail',[$product->slug]) }}">{{ $product->name }}</a></li>
                        @endforeach
                        <li><a class="text-decoration-none" href="{{ route('product') }}">Produk lainnya..</a></li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Informasi</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="{{ route('index') }}">Beranda</a></li>
                        <li><a class="text-decoration-none" href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a class="text-decoration-none" href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

            </div>

            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <div class="col-auto me-auto">
                    <ul class="list-inline text-left footer-icons">
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/"><i class="fab fa-linkedin fa-lg fa-fw"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="subscribeEmail">Email address</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control bg-dark border-light" id="subscribeEmail" placeholder="Email address">
                        <div class="input-group-text btn-success text-light">Subscribe</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 bg-black py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-left text-light">
                            Copyright &copy; 2021 {{ $company->name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- End Footer -->


    <a href="https://api.whatsapp.com/send/?phone={{ $company->telp }}&text=Halo%20{{ $company->name }}" class="float-ok" target="_blank">
        <i class="fa fa-whatsapp my-float-ok"></i>
        </a>

    <!-- Start Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/templatemo.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <!-- End Script -->

    <!-- Start Slider Script -->
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                }
            ]
        });
    </script>

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-L6JNN02NBY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-L6JNN02NBY');
</script>
    <!-- End Slider Script -->

</body>

</html>
