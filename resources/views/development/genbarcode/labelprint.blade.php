<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>QR Print</title>
    <style type="text/css">
        .barcodeTag td {
            padding: 0.1cm;
        }
        .barcode {
            width: 3.7cm;
            height: 1.8cm;
        }
        @font-face{
            font-family: 'ocrb';
            src: '{{ asset('fonts/OCR-B-Regular.ttf') }}';
            /*src: url('font/OCR-B-Regular.ttf');*/
        }
        .ocrb {
            font-family: ocrb;
        }
    </style>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/JsBarcode.all.min.js') }}"></script>
    {{--<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>--}}
    {{--<script type="text/javascript" src="js/JsBarcode.all.min.js"></script>--}}
    <script type="text/javascript">
        $().ready(function() {
            var data = [];
            @foreach($rowData as $rowval)
            data.push({
                barCode1 : {
                    val : '{{ $rowval[0] }}',
                },
            });
            @endforeach

            GenHtml(data);
            SetBarCode(data);

            var barcodeOptions = {
                font: 'OCR-B',
                width: '3.7cm',
                height: '1.8cm'
            }

            function SetBarCode(data) {
                for(var i=0;i < data.length;i++) {
                    JsBarcode("#barcode1-"+i, data[i].barCode1.val, {format:"UPC" ,height: 100});//width: '3.7cm', height: '1.8cm'
                }
            }


            function GenHtml (data) {
                var h = [];
                for(var i=0;i < data.length;i++) {
                    GenSingleTag(data[i], h, i);
                }
                $('#content').html(h.join(''));

            }

            function GenSingleTag(obj, h, tagIndex) {
                var _ = h.push;
                h.push('<div class="barcodeTag" >');
                h.push('    <table  cellpadding="0" cellspacing="0" style="width:100%;height:100%">');
                h.push('        <tbody>');
                h.push('         <tr>');
                h.push('             <td><div><img class="barcode" id="barcode1-',tagIndex,'" /></div></td>');
                h.push('         </tr>');
                h.push('     </tbody>');
                h.push('    </table>');
                h.push('</div>');
            }
        });
    </script>
</head>
<body>
<div id="content"></div>
</body>
</html>