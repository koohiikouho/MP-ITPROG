<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Index</title>

    <!-- Initialize bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <style>
        .input-no-box {
            border: none;
            background-color: transparent;
            box-shadow: none;
        }
        .form-control::placeholder {
            font-style: italic;
        }
        .bold-input .form-control{
            font-weight: bold;
        }
        .bold-input .form-control::placeholder {
            font-weight: normal;
        }
        .custom-input {
            height: 40px;
            font-size: 2rem;
        }
        .dont-pad-me {
            padding-right: 0;
        }
        .fade {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .fade.show {
            opacity: 1;
        }
        .faderev{
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        .faderev.hide {
            opacity: 0;
        }
        .fh-color{
            background-color: #Ac8ce1;
        }
        body {
            background-color: #fcf7ff;
        }
        h3 {
            color: #0b003a;
        }
        .custom-input{
            color: #0b003a;
        }
        .subtext {
            color: #736b97;
        }
        .rectangle {
            height: 10px;
            width: 100%;
            background-color: #000000;
            opacity: 0.3;
          }
    </style>
</head>
<body>
    <!-- script stuff -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="jQuery/anims.js"></script>
    <script src ="jQuery/func.js"></script>
    <!-- Initialize bootstrap  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Open DB Conn -->
    <?php
        // Change acc to your machine
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dbpcpartspicker";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully";
    ?>

    <div class = "container-fluid mb-5">
        <div class = "row d-flex">
            <nav class="navbar navbar-expand-lg fade fh-color" id="myNavbar">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="ml-5 navbar-brand"></a>
                <img src="images/navbar-logo.webp" width="50" height="50" class="d-inline-block align-top" alt="">
                <a class="navbar-brand" style="color: #ffffff">The Herta's Part Picker Thing</a>
              </nav>
        </div>
        <div class = "row d-flex" >
            <div class="rectangle" id ="navbarShadow"></div>
        </div>
    </div>



    <div class ="row fade" id="myInput">
        <div class ="col-10 ">
            <div class ="row justify-content-center mt-3"> 
                <div class="col-sm-10 gx-5">
                    <h1>
                        <div class="mb-3">
                        <!-- REMEMBER TO CHANGE ID -->
                            <div class="bold-input">                        
                                <input type="text" class="form-control form-control-lg input-no-box custom-input " id="exampleFormControlInput1" placeholder="Name your pc build...">
                            </div>
                        </div>
                    </h1>
                    <hr class="my-4">
                    <!-- CARD FOR CPU -->
                    <!-- IDs ARE AS FOLLOWS -->
                    <!-- 
                    cpuBrand
                    cpuCores
                    cpuSearch
                    cpuName
                    cpuloading //hidden at start
                    cpudesc //hidden at start
                    addcpubutton
                    removecpubutton //hidden at start
                    cpuSort
                    -->
                    <div class ="card shadow custom-card-border custom-card-background">
                        <div class="container-fluid">
                            <div class="row mt-4 mb-4">
                                <div class="col-2">
                                    <div class="text-nowrap">
                                        <h3>CPU</h3>
                                    </div>
                                </div>
                                
                                
                                <div class="col-9">
                                        <div class ="row" id="cpuDataList">
                                            <div class="col-3">
                                                <p>Brand: </p>
                                                <div class="form-group">
                                                    <select class="form-control" id="cpuBrand">
                                                        <!-- TODO: do your back end magic here PLACEHOLDER VALUES-->
                                                        <?php
                                                            $sql = "SELECT DISTINCT rv.mbid 
                                                                    FROM processors p
                                                                    JOIN ref_vendors rv ON p.vendorCode = rv.mbid;";
                                                            $result = $conn->query($sql);

                                                            // Check if there are results
                                                            if ($result->num_rows > 0) {
                                                                echo "<option value='' disabled selected>Select a brand</option>";
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo "<option value='" . $row['mbid'] . "'>" . $row['mbid']  . "</option>";
                                                                }
                                                            } else {
                                                                echo "<option disabled>No brands available</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="col-3">
                                                <p>Cores: </p>
                                                <div class="form-group">
                                                    <select class="form-control" id="cpuCores">
                                                        <!-- TODO: do your back end magic here PLACEHOLDER VALUES-->
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                             </div>
                                             <div class="col-1">
                                                <div class="d-flex form-group mb-2">
                                                    <button type="button" class="btn btn-outline-primary w-100" id="cpuSearch">🔍</button>
                                                </div>
                                                Sort by:
                                                <div class="d-flex form-group mt-1">
                                                    <select class="form-control" id="cpuSort">
                                                        <!-- TODO: do your back end magic here PLACEHOLDER VALUES-->
                                                        <option>💵</option>
                                                        <option>📈</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-5">
                                                <p>Select part:</p>
                                                <div class="form-group">
                                                    <select class="form-control" id="cpuName">
                                                        <!-- TODO: do your back end magic here PLACEHOLDER VALUES-->
                                                        <option disabled selected style="display:none;"> </option>
                                                        <option > Mambo 2000x </option>
                                                    </select>
                                                </div>
                                             </div>
                                        </div>
                                    
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status" id="cpuLoading">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <h3 id = "cpuProdName"></h3>
                                    <div class="container">
                                        <p class="pl-3 subtext" id = "cpuDesc"></p>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-outline-success w-100 h-100" id="addCpuButton">+</button>
                                    <button type="button" class="btn btn-outline-danger w-100 h-100" id="remCpuButton">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD FOR Motherboard -->
            <!-- IDs ARE AS FOLLOWS -->
            <!-- 
                moboBrand
                moboChipset
                moboSearch
                moboSort
                moboLoading //hidden at start
                moboDesc //hidden at start
                addMoboButton
                remMoboButton //hidden at start
                moboDatalist
                moboWarning
            -->
            <div class ="row justify-content-center mt-3"> 
                <div class="col-sm-10 gx-5">
                    <div class ="card shadow custom-card-border custom-card-background">
                        <div class="container-fluid">
                            <div class="row mt-4 mb-4">
                                <div class="col-2">
                                    <div class="text-nowrap">
                                        <h3>Motherboard</h3>
                                    </div>
                                </div>


                                <div class="col-9">
                                    <div class ="row text-center" id="moboWarning">
                                        <h1 class="mt-2"style="color: gray;">Select CPU First</h1>
                                    </div>
                                    <div class ="row" id="moboDataList">
                                        <div class="col-3">
                                            <p>Brand: </p>
                                            <div class="form-group">
                                                <select class="form-control" id="moboBrand">
                                                    
                                                        <?php
                                                            $sql = "SELECT DISTINCT rv.mbid 
                                                                    FROM processors p
                                                                    JOIN ref_vendors rv ON p.vendorCode = rv.mbid;";
                                                            $result = $conn->query($sql);

                                                            // Check if there are results
                                                            if ($result->num_rows > 0) {
                                                                echo "<option value='' disabled selected>Select a brand</option>";
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo "<option value='" . $row['mbid'] . "'>" . $row['mbid']  . "</option>";
                                                                }
                                                            } else {
                                                                echo "<option disabled>No brands available</option>";
                                                            }
                                                        ?>
                                                    <option selected>Gigabyte</option>
                                                    <option>ASUS</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="col-3">
                                            <p>Chipset: </p>
                                            <div class="form-group">
                                                <select class="form-control" id="moboChip">
                                                    <!-- do your back end magic here PLACEHOLDER VALUES-->
                                                    <option>B450</option>
                                                    <option>A320</option>
                                                    <option>X570</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="col-1">
                                            <div class="d-flex form-group mb-2">
                                                <button type="button" class="btn btn-outline-primary w-100" id="moboSearch">🔍</button>
                                            </div>
                                            Sort by:
                                            <div class="d-flex form-group mt-1">
                                                <select class="form-control" id="moboSort">
                                                    <!-- do your back end magic here PLACEHOLDER VALUES-->
                                                    <option>💵</option>
                                                    <option>📈</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-5">
                                            <p>Select part:</p>
                                            <div class="form-group">
                                                <select class="form-control" id="moboName">
                                                    <!-- do your back end magic here PLACEHOLDER VALUES-->
                                                    <option disabled selected style="display:none;"> </option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                            </div>
                                         </div>
                                    </div>
                                
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status" id="moboLoading">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <h3 id = "moboProdName"></h3>
                                <div class="container">
                                    <p class="pl-3 subtext" id = "moboDesc"></p>
                                </div>
                            </div>
                                <div class="col">
                                    <button type="button" class="btn btn-outline-success w-100 h-100 " id="addMoboButton">+</button>
                                    <button type="button" class="btn btn-outline-danger w-100 h-100 " id="remMoboButton">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD FOR Memory -->
            <!-- IDs ARE AS FOLLOWS -->
            <!-- 
                memBrand
                memSize
                memSearch
                memSort
                memLoading //hidden at start
                memProdDesc //hidden at start
                addMemButton
                remMemButton //hidden at start
                memDatalist
                mem Warning
            -->
            <!-- TODO: LINK EVERY SELECTOR/BUTTON TO JQUERY -->
            <div class ="row justify-content-center mt-3"> 
                <div class="col-sm-10 gx-5">
                    <div class ="card shadow custom-card-border custom-card-background">
                        <div class="container-fluid">
                            <div class="row mt-4 mb-4">
                                <div class="col-2">
                                        <div class="text-nowrap">
                                        <h3>Memory</h3>
                                    </div>
                                </div>

                                <div class="col-9">
                                    <div class ="row text-center" id="memWarning">
                                        <h1 class="mt-2"style="color: gray;">Select Motherboard First</h1>
                                    </div>
                                    <div class ="row" id="memDataList">
                                        <div class="col-3">
                                            <p>Brand: </p>
                                            <div class="form-group">
                                                <select class="form-control" id="memBrand">
                                                    <!-- TODO: do your back end magic here PLACEHOLDER VALUES-->
                                                    <option selected>Gigabyte</option>
                                                    <option>ASUS</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="col-3">
                                            <p>Chipset: </p>
                                            <div class="form-group">
                                                <select class="form-control" id="memSize">
                                                    <!-- do your back end magic here PLACEHOLDER VALUES-->
                                                    <option>B450</option>
                                                    <option>A320</option>
                                                    <option>X570</option>
                                                </select>
                                            </div>
                                         </div>
                                         <div class="col-1">
                                            <div class="d-flex form-group mb-2">
                                                <button type="button" class="btn btn-outline-primary w-100" id="memSearch">🔍</button>
                                            </div>
                                            Sort by:
                                            <div class="d-flex form-group mt-1">
                                                <select class="form-control" id="memSort">
                                                    <!-- do your back end magic here PLACEHOLDER VALUES-->
                                                    <option>💵</option>
                                                    <option>📈</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-5">
                                            <p>Select part:</p>
                                            <div class="form-group">
                                                <select class="form-control" id="memName">
                                                    <!-- do your back end magic here PLACEHOLDER VALUES-->
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                            </div>
                                         </div>
                                    </div>
                                
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status" id="memLoading">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <h3 id = "memProdName"></h3>
                                <div class="container">
                                    <p class="pl-3 subtext" id = "memProdDesc"></p>
                                </div>
                            </div>

                                <div class="col">
                                    <button type="button" class="btn btn-outline-success w-100 h-100 " id="addMemButton">+</button>
                                    <button type="button" class="btn btn-outline-danger w-100 h-100 " id="remMemButton">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class ="row justify-content-center mt-3"> 
                <div class="col-sm-10 gx-5">
                    <div class ="card shadow custom-card-border custom-card-background">
                        <div class="container-fluid">
                            <div class="row mt-4 mb-4">
                                <div class="col-2">
                                    <div class="text-nowrap">
                                        <h3>Storage</h3>
                                    </div>
                                </div>

                                <div class="col-5">
                                <p>Main OS Drive: </p>
                                <!-- REMEMBER TO CHANGE ID -->
                                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                <datalist id="datalistOptions">
                                    <!-- maybe we can use php here to query options for this -->

                                    <!-- Placeholder for now -->
                                <option value="San Francisco">
                                <option value="New York">
                                <option value="Seattle">
                                <option value="Los Angeles">
                                <option value="Chicago">
                                </datalist>
                                </div>
                                <div class="col-4">
                                <p>Storage Drive:</p>
                                <!-- REMEMBER TO CHANGE ID -->
                                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                <datalist id="datalistOptions">
                                    <!-- maybe we can use php here to query options for this -->

                                    <!-- Placeholder for now -->
                                <option value="San Francisco">
                                <option value="New York">
                                <option value="Seattle">
                                <option value="Los Angeles">
                                <option value="Chicago">
                                </datalist>
                                </div>
                                <div class="d-flex col justify-content-center mx-auto my-auto">
                                    <button type="button" class="btn btn-outline-success w-100 h-50 ">+ Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class ="row justify-content-center mt-3"> 
                <div class="col-sm-10 gx-5">
                    <div class ="card shadow custom-card-border custom-card-background">
                        <div class="container-fluid">
                            <div class="row mt-4 mb-4">
                                <div class="col-2">
                                    <div class="text-nowrap">
                                        <h3>Case</h3>
                                    </div>
                                </div>

                                <div class="col-9">
                                <!-- REMEMBER TO CHANGE ID -->
                                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                <datalist id="datalistOptions">
                                    <!-- maybe we can use php here to query options for this -->

                                    <!-- Placeholder for now -->
                                <option value="San Francisco">
                                <option value="New York">
                                <option value="Seattle">
                                <option value="Los Angeles">
                                <option value="Chicago">
                                </datalist>

                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-outline-success w-100">+ Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class ="row justify-content-center mt-3"> 
                <div class="col-sm-10 gx-5">
                    <div class ="card shadow custom-card-border custom-card-background">
                        <div class="container-fluid">
                            <div class="row mt-4 mb-4">
                                <div class="col-2">
                                    <div class="text-nowrap">
                                        <h3>PSU 
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247m2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"/>
                                                </svg>
                                        </h3>
                                    </div>
                                </div>                           

                                <div class="col-9">
                                <!-- REMEMBER TO CHANGE ID -->
                                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                <datalist id="datalistOptions">
                                    <!-- maybe we can use php here to query options for this -->
                                    <!-- Placeholder for now -->
                                <option value="San Francisco">
                                <option value="New York">
                                <option value="Seattle">
                                <option value="Los Angeles">
                                <option value="Chicago">
                                </datalist>

                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-outline-success w-100">+ Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class ="row justify-content-center mt-3"> 
                <div class="col-sm-10 gx-5">
                    <div class ="card shadow custom-card-border custom-card-background">
                        <div class="container-fluid">
                            <div class="row mt-4 mb-4">
                                <div class="col-2">
                                    <div class="text-nowrap">
                                        <h3>GPU 
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247m2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"/>
                                                </svg>
                                        </h3>
                                    </div>
                                </div>                           

                                <div class="col-9">
                                <!-- REMEMBER TO CHANGE ID -->
                                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                <datalist id="datalistOptions">
                                    <!-- maybe we can use php here to query options for this -->
                                    <!-- Placeholder for now -->
                                <option value="San Francisco">
                                <option value="New York">
                                <option value="Seattle">
                                <option value="Los Angeles">
                                <option value="Chicago">
                                </datalist>

                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-outline-success w-100">+ Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

        </div>

        <div class="col-auto mt-5">
            <div class ="mt-4">
                <div class ="mt-2">
                    <br>
                    <br>
                    <div class="d-flex" style="height: 800px;">
                        <div class="vr"></div>
                    </div>
                </div>

            </div>
        </div>

            <div class="col-auto mt-5">
                <br>
                <br>
                <br>
                <h5>Generated List Goes Here</h5>
            </div>
    </div>


    <footer class="text-center text-white fade fh-color mt-5" id="myFooter">
        <!-- Grid container -->
        <div class="container p-4">
          <!-- Section: Iframe -->
          <section class="">
            <div class="row d-flex justify-content-center">
              <div class="col-lg-6">
                <div class="ratio ratio-16x9">
                  <iframe
                    class="shadow-1-strong rounded"
                    src="https://www.youtube.com/embed/pneAqiHXpWw?si=Lke8oBSu4FVSO8Qp"
                    title="YouTube video"
                    allowfullscreen
                  ></iframe>
                </div>
              </div>
            </div>
          </section>
          <!-- Section: Iframe -->
        </div>
        <!-- Grid container -->
      
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
          © 2024 Copyright:
          <a class="text-white" href="https://mdbootstrap.com/">Herta Space Station Programmers</a>
        </div>
        <!-- Copyright -->
      </footer>

<?php $conn->close();?>

</body>
</html>