<?
session_start();
if($_SESSION['admin']==false){
    header("Location: http://eed13c9e9cce.eu.ngrok.io/auth.php");
    exit;
   }
if($_GET['do'] == 'logout'){
    unset($_SESSION['admin']);
    session_destroy();
    header("Location: http://eed13c9e9cce.eu.ngrok.io/prebuilt-solutions/index.php");
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
    <script src="/js/prebuilt-solutions-admin.js"></script>
    
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
                        <a class="nav-link" href="/products/">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/prebuilt-solutions/">Prebuilt Solutions</a>
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
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="all">All Variants</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="game">Gaming PC</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="home">Study and Work</button></li>
                                    <li><button class="dropdown-item choose-search-criteria" search-criteria="base">Basic PC</button></li>
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
                <form id="pc-form-create" class="admin-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                <div class="mb-1">
                                    <label for="pc-create-inputCPU" class="form-label">CPU   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="cpu" class="form-control" id="pc-create-inputCPU" aria-describedby="emailHelp" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputFan" class="form-label">Fan   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="fan" class="form-control" id="pc-create-inputFan" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputMotherboard" class="form-label">Motherboard   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="motherboard" class="form-control" id="pc-create-inputMotherboard" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputGPU" class="form-label">GPU   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="gpu" class="form-control" id="pc-create-inputGPU" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputDrive" class="form-label">Hard Drive   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="drive" class="form-control" id="pc-create-inputDrive" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputSSD" class="form-label">SSD</label>
                                    <input type="text" name="ssd" class="form-control" id="pc-create-inputSSD">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputPower" class="form-label">Power Supply   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="power" class="form-control" id="pc-create-inputPower" required="required">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="mb-1">
                                    <label for="pc-create-inputRAM" class="form-label">RAM   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="ram" class="form-control" id="pc-create-inputRAM" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputNetwork" class="form-label">Network</label>
                                    <input type="text" name="network" class="form-control" id="pc-create-inputNetwork">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputOS" class="form-label">OS</label>
                                    <input type="text" name="os" class="form-control" id="pc-create-inputOS">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputCase" class="form-label">Case   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input type="text" name="pccase" class="form-control" id="pc-create-inputCase" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputPrice" class="form-label">Price   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input class="form-control" name="price" id="pc-create-inputPrice" placeholder="price" type="text" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputImage" class="form-label">Image   <span class="badge bg-warning text-dark">Important</span></label>
                                    <input class="form-control" type="file" name="myimage" id="pc-create-inputImage" accept=".jpg,.png,.jpeg,.pic" required="required">
                                </div>
                                <div class="mb-1">
                                    <label for="pc-create-inputGIndex" class="form-label">Purpose   <span class="badge bg-warning text-dark">Important</span></label>
                                    <select id="pc-create-inputGIndex" name="gindex" class="form-select" aria-label="Default select example" required="required">
                                        <option selected>Select type of pc</option>
                                        <option value="game">Gaming PC</option>
                                        <option value="home">Study and Work</option>
                                        <option value="base">Basic PC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pc-create-inputDescription" class="form-label">Description   <span class="badge bg-warning text-dark">Important</span></label>
                                <textarea name="description" id="pc-create-inputDescription" class="form-control" rows="9" cols="25" required="required" placeholder="Description for PC" required="required"></textarea>
                            </div>
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