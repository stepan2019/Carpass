<?php
session_start();
if (!@$_SESSION['user']) {
    header("location:/index.php");
}
include "../setting/config.php";

if (isset($_POST['vin'])) {
    $plate = $_POST['vin'];

    $resultByPlate = $config->get_vehicle_by_plate($plate);
    $countByPlate = $resultByPlate->num_rows;

    $resultByVIN = $config->get_vehicle_by_vin($plate);
    $countByVIN = $resultByVIN->num_rows;

    if ($countByPlate > 0)
        $vehicle_info = $resultByPlate->fetch_assoc();
    else
        $vehicle_info = $resultByVIN->fetch_assoc();
    $car_id = $vehicle_info['id'];
    $user_id = $vehicle_info['user_id'];
    $user_type = $vehicle_info['type'];

    if ($user_type == "user")
        $result = $config->getUserById($user_id);
    else
        $result = $config->getDealerById($user_id);

    $user_info = $result->fetch_assoc();



    $result = $config->reportCount();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car pass - Report Generate</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/invoice.css" rel="stylesheet">

    <style type="text/css">
        .table-bordered {
            border: 2px solid #fe7500;
        }

        .table-bordered tbody td, .table-bordered thead th {
            border: 1px solid #fe7500;
        }
    </style>
</head>

<body class="container">
<div class="row">
    <div class="col-md-12 text-center btn-field">
        <button onclick="if (!window.__cfRLUnblockHandlers) return false; getPDF()" id="downloadbtn"
                data-cf-modified-3041e76d3da1bfb24a107310-=""><b>Download as PDF</b></button>
        <button onclick="printThis()"><b> Print</b></button>
        <button class="button" onclick="closeWindow()"><b> Close this window</b></button>
        <button onclick="reportPage()" id="pdf_btn"><b>Back to report</b></button>
    </div>
</div>

<div class="canvas_div_pdf mt-2" style="display: block;">

    <div class="top_map_section clearfix">
        <div class="row col-md-12 text-left mt-4">
            <div class="col-md-4" style="margin-top:20px;">
                <p><b>Invoice from:</b></p>
                <p style="font-size:50px;font-weight: bold;">Carpass</p>
            </div>
            <div class="col-md-8 logo-img"></div>
        </div>
        <div class="row col-md-12">
            <p style="font-size:40px;font-weight: bold;">Athene, Greece</p>
        </div>
        <hr style="border: 5px solid gray;">
        <div class="row col-md-12">
            <p><b>Invoice to:</b></p>
        </div>
        <?php
        if ($user_type == "user") {
            ?>
            <div class="row col-md-12">
                <div class="col-md-4" style="">
                    <p style="font-size: 30px; font-weight:bold;"><?php echo $user_info['name']; ?></p>
                    <p style="font-size: 30px; font-weight:bold;"><?php echo $user_info['address']; ?></p>
                </div>
                <div class="offset-md-4 col-md-4" style="">
                    <p style="font-size: 20px; font-weight:bold;">INVOICE : 10</p>
                    <p style="font-size: 20px; font-weight:bold;">Invoice date : <?php echo date('Y-m-d');?></p>
                    <p style="font-size: 20px; font-weight:bold;">Order Amount :
                        <span style="font-size:30px;font-style: italic;" ><?php echo '5CE';?></span>
                    </p>
                </div>
            </div>
        <?php } else { ?>
        <div class="row col-md-12">
            <div class="col-md-4">
                <p style="font-size: 24px; margin-bottom: 0px;"><?php echo $user_info['company']; ?></p>
                <p style="font-size: 24px; margin-bottom: 0px;"><?php echo $user_info['address']; ?></p>
            </div>
            <div class="offset-md-4 col-md-4" style="">
                <p style="font-size: 20px; font-weight:bold;">INVOICE : 10</p>
                <p style="font-size: 20px; font-weight:bold;">Invoice date : <?php echo date('d/m/Y');?></p>
                <p style="font-size: 20px; font-weight:bold;">Order Amount : 
                    <span style="font-size:30px;font-style: italic;" ><?php echo '5CE';?></span>
                </p>
            </div>
        </div>
        <?php } ?>

            <?php
                $result = $config->getPrice();
                $price = $result->fetch_assoc();
            ?>

        <table class="table table-bordered">
            <thead style="background-color:#619DDB;">
            <tr>
                <th class="text-center" width="200px">Product</th>
                <th class="text-center" width="50px">Qty</th>
                <th class="text-center" width="50px">Price</th>
                <th class="text-center" width="100px">Line total</th>
                <th class="text-center" width="100px">Tax</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">Car Km registration</td>
                <td class="text-center">1</td>
                <td class="text-center" style="font-style: italic;"><?php echo $price['price']; ?>CE</td>
                <td class="text-center"><?php echo ''; ?></td>
                <td class="text-center"><?php echo $price['tax']; ?> %</td>
            </tr>
            </tbody>
        </table>
        <div class="offset-md-9 col-md-3">
            <p style="font-size:20px;">
                Subtotal : <?php echo $price['price']; ?>
            </p>
            <p style="font-size:20px;">
                Discount : <?php echo ($price['tax']) ? $price['tax']*$price['price']/100 : '£0.00'; ?>
            </p>
            <p style="font-size:20px;font-weight: bold;font-style: italic;">
                Total : <?php echo ($price['tax']*$price['price']/100 + $price['price']); ?>CE
            </p>
        </div>
        <hr style="border: 5px solid gray;">
        <div class="row col-md-12" style="margin-top:50px;background-color:gray;margin-bottom:50px;">
            <p style="font-size:25px;font-weight: bold;">Thanks for Registration of your Vehicle and thanks for your order and payment</p>
        </div>
    </div>
</div>
<form action="pdf.php" method="post" id="invoice_form" target="_self" name="invoice_form">
    <input type="hidden" name="vin" value="<?php echo $_POST['vin']; ?>"/>
</form>
<script src="https://code.jquery.com/jquery-1.11.3.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js" type="text/javascript"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js" type="text/javascript"></script>

<script type="text/javascript">
    function getPDF() {
        $("#downloadbtn").hide();
        $("#genmsg").show();
        var HTML_Width = $(".canvas_div_pdf").width();
        var HTML_Height = $(".canvas_div_pdf").height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width + (top_left_margin * 2);
        var PDF_Height = (PDF_Width * 1.2) + (top_left_margin * 2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;

        var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

        html2canvas($(".canvas_div_pdf")[0], {allowTaint: true}).then(function (canvas) {
            canvas.getContext('2d');

            console.log(canvas.height + "  " + canvas.width);

            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);

            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4), canvas_image_width, canvas_image_height);
            }

            pdf.save("HTML-Document.pdf");

            setTimeout(function () {
                $("#downloadbtn").show();
                $("#genmsg").hide();
            }, 0);

        });
    };

    function closeWindow() {
        if (confirm("Close Window?")) {
            window.close();
        }
    };

    function printThis() {
        console.log("print this page....");
        $(".btn-field").hide();
        window.print();
    };
    function reportPage(){
        document.forms[0].submit();
    }
</script>

<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/a2bd7673/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="3041e76d3da1bfb24a107310-|49" defer=""></script>
</body>
</html>
