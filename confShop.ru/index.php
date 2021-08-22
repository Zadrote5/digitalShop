<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PC Builder</title>

    <link type="text/css" href="/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="/css/main.css" rel="stylesheet">
    <link type="text/css" href="/css/bootstrap-icons.css" rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="/js/config.js"></script>
</head>
<body>
    <!-- Header Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">PC Market</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/configurator/">Configurator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/products/">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/prebuild-solutions/">Prebuilt Solutions</a>
                    </li>
                </ul>

                <!-- Dropdown Start -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="ComponentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            PC Components
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="/products/?category=all">All Categories</a></li>
                            <li><a class="dropdown-item" href="/products/?category=cpu">CPU</a></li>
                            <li><a class="dropdown-item" href="/products/?category=motherboard">Motherboard</a></li>
                            <li><a class="dropdown-item" href="/products/?category=gpu">GPU</a></li>
                            <li><a class="dropdown-item" href="/products/?category=ram">RAM</a></li>
                            <li><a class="dropdown-item" href="/products/?category=fan">Fan</a></li>
                            <li><a class="dropdown-item" href="/products/?category=network">Network Card</a></li>
                            <li><a class="dropdown-item" href="/products/?category=drive">Hard Drive</a></li>
                            <li><a class="dropdown-item" href="/products/?category=ssd">Solid State Drive</a></li>
                            <li><a class="dropdown-item" href="/products/?category=power">Power Supply</a></li>
                            <li><a class="dropdown-item" href="/products/?category=case">Case</a></li>
                            <li><a class="dropdown-item" href="/products/?category=os">Operating System</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="PeripheralsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Peripherals
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="/products/?category=keyboard">Keyboard</a></li>
                            <li><a class="dropdown-item" href="/products/?category=mouse">Mouse</a></li>
                            <li><a class="dropdown-item" href="/products/?category=display">Display</a></li>
                            <li><a class="dropdown-item" href="/products/?category=headset">Headset</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="CurrencyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Currency
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><button class="dropdown-item choose-currency" currency="USD">Dollars</button></li>
                            <li><button class="dropdown-item choose-currency" currency="RUB">Rubles</button></li>
                            <li><button class="dropdown-item choose-currency" currency="UAH">Hryvnia</button></li>
                        </ul>
                    </li>
                </ul>
                <!-- Dropdown End -->
            </div>
        </div>
    </nav>
    <!-- Header End -->

    <!-- Configuration PC Start -->
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <!-- Configuration Items Start -->
                <div class="order-items-row">

                    <div class="card text-white bg-primary mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">This site will help you customize your PC build. </h5>
                                    <p class="card-text">Click one of the buttons on the adjacent card or use the navigation links in the header to view the configurations.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Configuration Items End -->
            </div>

            <div class="col-sm">
                <!-- Configuration Price Start -->
                <div class="order-items-row">
                    <div class="card text-white bg-primary">
                        <div class="card-header">
                            <h5>Choose page</h5>
                        </div>
                        <div class="card-body">
                            <a href="/configurator/" class="btn btn-secondary">Configurator</a>
                            <a href="/gallery/" class="btn btn-secondary">Prebuilt Solutions</a>
                        </div>
                    </div>
                </div>
                <!-- Configuration Price End -->
            </div>

        </div>
    </div>
    <!-- Configuration PC End -->

</body>
</html>