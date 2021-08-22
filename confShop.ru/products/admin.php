<?
session_start();
if($_SESSION['admin']==false){
    header("Location: http://eed13c9e9cce.eu.ngrok.io/auth.php");
    exit;
   }
if($_GET['do'] == 'logout'){
    unset($_SESSION['admin']);
    session_destroy();
    header("Location: http://eed13c9e9cce.eu.ngrok.io/products/index.php");
   }

?>


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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="/js/config.js"></script>
    <script src="/js/products-admin.js"></script>
    
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
                        <a class="nav-link" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/configurator/">Configurator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/products/">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/prebuilt-solutions/">Prebuilt Solutions</a>
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
                <div id="components-array" class="order-items-row row-available">

                </div>
                <!-- Configuration Items End -->
            </div>

            <div class="col-sm">
                <!-- Configuration Price Start -->
                <div class="order-items-row">

                    <div class="card text-white bg-primary">
                        <div class="card-header">
                            Search Criteria
                        </div>
                        <div class="card-body">
                            <div class="btn-group">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addComponentModal" class="btn btn-success btn-add-to-config"><i class="bi bi-plus-lg"></i></button>
                                <button id="select-category-button" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Category
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="all">All Categories</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="cpu">CPU</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="fan">Fan</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="motherboard">Motherboard</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="gpu">GPU</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="ram">RAM</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="network">Network Card</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="drive">Hard Drive</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="power">Power Supply</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="case">Case</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="os">Operating System</button></li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Configuration Price End -->

                <!-- Alert Start -->
                <div id="proceed-alert" class="alert alert-danger" role="alert" style="display: none">
                    Check important components before proceed!
                </div>

                <!-- Alert End -->

            </div>

        </div>
    </div>
    <!-- Configuration PC End -->

    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">WARNING</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-delete-confirm" data-bs-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-primary">No</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addComponentModal" tabindex="-1" aria-labelledby="addComponentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="products-form-create" class="admin-form">
                        <div class="row">
                            <div class="col-sm">
                                <div class="mb-1">
                                    <label for="products-create-inputCPU" class="form-label">Name   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="name" class="form-control" id="products-create-inputCPU" aria-describedby="emailHelp" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="products-create-inputFan" class="form-label">Socket</label>
                                    <input type="text" name="socket" class="form-control" id="products-create-inputFan" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="products-create-inputMotherboard" class="form-label">Category   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="category" class="form-control" id="products-create-inputMotherboard" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="products-create-inputGPU" class="form-label">Price   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="price" class="form-control" id="products-create-inputGPU" required="required">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="component-create-inputImage" class="form-label">Image   <span class="badge bg-warning text-dark">Important</span></label>
                                <input class="form-control" type="file" name="myimage" id="component-create-inputImage" accept=".jpg,.png,.jpeg,.pic" required="required">
                            </div>
                            <div class="mb-3">
                                <label for="products-create-inputDescription" class="form-label">Description   <span class="badge bg-warning text-dark">Important</span></label>
                                <textarea name="description" id="products-create-inputDescription" class="form-control" rows="9" cols="25" required="required" placeholder="Description for PC" required="required"></textarea>
                            </div>
                        </div>

                </form>
                <div class="mb-1">
                    <button type="submit" class="btn btn-primary btn-submit-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>