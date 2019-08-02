<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
file has uploaded. Shipment invoice number: {{ $shipment->invoice_number }}, file name: {{ substr($shipmentattachment->path, strrpos($shipmentattachment->path, "/") + 1) }}.
</body>
</html>