<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('images/icon.png') }}" rel="icon" type="image/gif">
    <title>K2 Support</title>

    @include('templates.TagHeader')

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Main.css') }}">



    {{-- Pusher Broadcast --}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    {{-- Bootstrap 4 Chartjs pie chart --}}
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>

</head>

<body>

    @include('component.Loading')


    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        @include('component.Left_Navbar')

        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="page-title mb-0 p-0">Gen หนังสือบอกเลิกสัญญา</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Gen หนังสือบอกเลิกสัญญา</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid main-content">

                <h5>ตัวอย่าง template ไฟล์ Excel</h5>

                <img src="{{ asset('images/cancel_contract.png') }}" class="img-fluid mb-4" alt="...">

                <hr>

                <form>
                    <div class="row">
                        <div class="col-6">
                            <p class="fs-2">อัปโหลดไฟล์ Excel <span class="text-danger fs-2">ตรวจสอบด้วยว่าตรงตาม
                                    template ไหม</span></p>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="file_upload">
                                <label class="input-group-text" for="file_upload">Upload</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 text-center">
                            <button type="button" class="btn btn-warning" id="btn_upfile">Upload file</button>
                        </div>
                    </div>
                </form>

                @include('component.footer')
            </div>

        </div>

    </div>


</body>

</html>



<script>
    $(document).ready(function() {

        $('#btn_upfile').on('click', function() {
            var files = document.getElementById('file_upload').files;
            if (files.length == 0) {
                alert("Please choose any file...");
                return;
            }
            var filename = files[0].name;
            var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
            if (extension == '.XLS' || extension == '.XLSX') {
                excelFileToJSON(files[0]);
            } else {
                alert("Please select a valid excel file.");
            }
        })

        function excelFileToJSON(file) {
            try {
                var reader = new FileReader();
                reader.readAsBinaryString(file);
                reader.onload = function(e) {

                    var data = e.target.result;
                    var workbook = XLSX.read(data, {
                        type: 'binary'
                    });
                    var result = {};
                    workbook.SheetNames.forEach(function(sheetName) {
                        var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                        if (roa.length > 0) {
                            result[sheetName] = roa;
                        }
                    });
                    //displaying the json result
                    if (isEmpty(result)) {
                        alert("อ่านไฟล์ไม่ได้ อัปให้ถูก");
                        document.getElementById('file_upload').value = null;
                        return
                    }
                    // 
                    Setup_data(Object.values(result)[0]);
                }
            } catch (e) {
                alert("อ่านไฟล์ไม่ได้ อัปให้ถูก");
                document.getElementById('file_upload').value = null;
            }
        }

        function isEmpty(obj) {
            return Object.keys(obj).length === 0;
        }


        function Setup_data(list_cus) {
            try {
                list_contract = []
                list_cus.forEach((set_obj) => {
                    list_contract.push({
                        Contract_number: set_obj['Contract No.']
                            .toString()
                            .replace(/[~`!@#$%^&*()+={}\[\];:\'\"<>.,\/\\\?-_]/g, '')
                            .trim(),
                        Install_PAY: Object.values(set_obj)[4],
                        Install_OD_01: Object.values(set_obj)[6],
                        SUM_PAY_AMT: Object.values(set_obj)[5],
                        Install_OD_02: Object.values(set_obj)[7],
                        Install_OD_Sum: Object.values(set_obj)[8],
                        SUM_OD_AMT: Object.values(set_obj)[9],
                        SUM_OD_Total: Object.values(set_obj)[10],
                        SUM_OUTSTAND_Total: Object.values(set_obj)[11],
                        SUM_PAY_AMT_TEXT: Object.values(set_obj)[5],
                        SUM_OD_AMT_TEXT: Object.values(set_obj)[9],
                        SUM_OD_Total_TEXT: Object.values(set_obj)[10],
                        SUM_OUTSTAND_Total_TEXT: Object.values(set_obj)[11],
                    })
                })
                // console.log(list_contract)
                Post_Data_Content(list_contract);
            } catch (e) {
                alert("อ่านไฟล์ไม่ได้ อัปให้ถูก");
                document.getElementById('file_upload').value = null;
            }
        }


        function Post_Data_Content(list) {
            $(".background_loading").css("display", "block");
            axios({
                    method: 'POST',
                    url: 'post_CancelContract',
                    data: {
                        list: list,
                    },
                }).then(function(response) {
                    $(".background_loading").css("display", "none");
                    alert("Success")
                })
                .catch(function(error) {
                    $(".background_loading").css("display", "none");
                    alert("Error")
                });

            document.getElementById('file_upload').value = null;
        }

    });
</script>
