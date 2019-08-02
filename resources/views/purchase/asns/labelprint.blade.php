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
        @foreach($asn->asnshipments as $asnshipment)
            @foreach($asnshipment->asnorders as $asnorder)
                @foreach($asnorder->asnpackagings as $asnpackaging)
                    @foreach($asnpackaging->asnitems as $asnitem)
                        data.push({
            name : 'TAL APPAREL LIMITED',
            poId : '{{ $asnorder->pohead->poheadc->purchase_order_number }}',
            refId : '{{ $asnorder->pohead->poheadc->interchange_receiver_id }}',
            matCode : '{{ $asnpackaging->poitem->poitemc->material_code }}',
            shipFrom : '{{ $asnorder->pohead->poheadc->supplier_name }}',
            shipTo : '{{ $asnorder->pohead->poheadc->ship_to }}',
            fabric : {
                title : '{{ trim(str_limit($asnpackaging->poitem->poitemc->fabric_description, 60)) }}',
                color : '{{ $asnpackaging->poitem->poitemc->color_desc1 }}',
                pattern : 3,    // ???
                lotId : '{{ $asnpackaging->dyelotseries }}',
                shadeId : '',
                rollId: {{ $asnitem->poitemroll->roll_number }}
            },
            barCode1 : {
                val : '{{ $asnitem->poitemroll->ucc_number }}',
                qty : '{{ $asnitem->poitemroll->quantity_shipped }}YD',
                len : '{{ $asnitem->poitemroll->quantity_shipped }}YD',
                grwt : '{{ $asnitem->poitemroll->gross_weight . $asnitem->poitemroll->gross_unit }}',
                netwt : '{{ $asnitem->poitemroll->net_weight . $asnitem->poitemroll->net_unit }}'
            },
            ucc : '{{ substr($asnitem->poitemroll->ucc_number, strlen($asnitem->poitemroll->ucc_number) - 5) }}',
            fabricWidth : '{{ $asnitem->poitemroll->fabric_width . $asnitem->poitemroll->fabric_unit }}',
            barCode2 : '{{ $asnitem->poitemroll->ucc_number }}',
            barCode2Num : 'Lot#:{{ $asnpackaging->dyelotseries }}',
            barCode2Text : '{{ substr($asnitem->poitemroll->ucc_number, strlen($asnitem->poitemroll->ucc_number) - 5) }}  PO# {{ $asnorder->pohead->poheadc->purchase_order_number }}',
            barCode3 : '{{ $asnitem->poitemroll->ucc_number }}',
            barCode3Num : 'Lot#:{{ $asnpackaging->dyelotseries }}',
            barCode3Text : '{{ substr($asnitem->poitemroll->ucc_number, strlen($asnitem->poitemroll->ucc_number) - 5) }}  PO# {{ $asnorder->pohead->poheadc->purchase_order_number }}',
                        });
                        {{--alert('{{ $asnorder->pohead->poheadc->purchase_order_number }}');--}}
                    @endforeach
                  @endforeach
            @endforeach
        @endforeach
        
//        var data = [{
//            name : 'TAL APPAREL LIMITED',
//            poId : '1234567',
//            refId : '12345678',
//            matCode : 'FW32932932-1234',
//            shipFrom : 'AMFILTEX',
//            shipTo : 'GLOBAL MANUFACTURING INC.',
//            fabric : {
//                title : '100% COTTON PIQUE 20S/1 PIECEDYED,86\'210GM/M2',
//                color : '05 KHAKI',
//                pattern : 3,
//                lotId : '001 DD262-1',
//                shadeId : 'SH262-1',
//                rollId: 1
//            },
//            barCode1 : {
//                val : '(12)345670001234567890',
//                qty : '108.69YD',
//                len : '108.69YD',
//                grwt : '108.69YD',
//                netwt : '108.69YD'
//            },
//            barCode2 : '(12)345670001234567890',
//            barCode2Num : 'lot.No.11133',
//            barCode3 : '(12)345670001234567890',
//            barCode3Num : 'lot.No.22233',
//            ucc : '67890',
//            fabricWidth : '18.69IN'
//
//        }];
        //data.push(data[0]);//测试多个tag，多个tag会分页。
        GenHtml(data);
        SetBarCode(data);

        var barcodeOptions = {
            font: 'OCR-B',
            width: '3.7cm',
            height: '1.8cm'
        }

        function SetBarCode(data) {
            for(var i=0;i < data.length;i++) {
                //GenSingleTag(data[i], h, i);
                JsBarcode("#barcode1-"+i, data[i].barCode1.val, {font: 'OCR-B'});//width: '3.7cm', height: '1.8cm'
                JsBarcode("#barcode2-"+i, data[i].barCode2, {font: 'OCR-B',displayValue:false});
                JsBarcode("#barcode3-"+i, data[i].barCode3, {font: 'OCR-B',displayValue:false});
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
            h.push('<div class="barcodeTag" style="page-break-after: always;width:10cm;min-height:15cm;">');
            h.push('    <div>TAL APPAREL LIMITED</div>');
            h.push('    <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">');
            h.push('        <tbody>');
            h.push('            <tr>');
            h.push('                <td class="ocrb">PO#:'+obj.poId+'</td>');
            h.push('                <td>Ref#:'+obj.refId+'</td>');
            h.push('            </tr>');
            h.push('            <tr>');
            h.push('                <td colspan="2" class="ocrb">Material Code:'+obj.matCode);
            h.push('                </td>');
            h.push('            </tr>');
            h.push('            <tr>');
            h.push('                <td colspan="2">Ship From:'+obj.shipFrom);
            h.push('                </td> ');
            h.push('            </tr>');
            h.push('            <tr>');
            h.push('            <td colspan="2">');
            h.push('                 <ul style="list-style:none;padding-left: 0cm;margin:0cm;">');
            h.push('                     <li>Fabric: '+obj.fabric.title+'</li>');
            h.push('                     <li>Color:'+obj.fabric.color+'</li>');
            h.push('                     <li>Pattern/Size:'+obj.fabric.pattern+'</li>');
            h.push('                     <li class="ocrb">Lot#:'+obj.fabric.lotId+'</li>');
            h.push('                     <li>Roll#:'+obj.fabric.rollId+'</li>');
            h.push('                 </ul>');
            h.push('             </td> ');
            h.push('         </tr>');
            h.push('         <tr>');
            h.push('                <td rowspan="4" style="text-align:center;vertical-align:middle;"><div><div style="font-size:0.25cm;text-align:left;">UCC</div><div><img class="barcode" id="barcode1-',tagIndex,'" /></div></div></td>');
            h.push('                <td><div style="float:left;">Qty:</div><div class="ocrb" style="float:right;">'+obj.barCode1.qty+'</div></td>');
            h.push('         </tr>');
            h.push('         <tr>');
            h.push('             <td class="ocrb"><div style="float:left;">Length:</div><div class="ocrb" style="float:right;">'+obj.barCode1.len+'</div></td>');
            h.push('            </tr>');
            h.push('         <tr>');
            h.push('             <td class="ocrb"><div style="float:left;">Gr Wt:</div><div class="ocrb" style="float:right;">'+obj.barCode1.grwt+'</div></td>');
            h.push('            </tr>');
            h.push('         <tr>');
            h.push('             <td class="ocrb"><div style="float:left;">Net Wt:</div><div class="ocrb" style="float:right;">'+obj.barCode1.netwt+'</div></td>');
            h.push('            </tr>');
            h.push('         <tr>');
            h.push('            <td colspan="2">Ship To:'+obj.shipTo);
            h.push('            </td> ');
            h.push('         </tr>');
            h.push('         <tr>');
            h.push('             <td>&nbsp;</td>');
            h.push('             <td>&nbsp;</td>');
            h.push('         </tr>');
            h.push('         <tr>');
            h.push('             <td>');
            h.push('                    <div style="height:1.8cm;width:3.7cm;">');
            h.push('                        <span style="font-size:0.3cm">UCC(last 5 digits)</span><br/>');
            h.push('                        <b style="font-size:1cm" class="ocrb">'+obj.ucc+'</b>');
            h.push('                    </div>');
            h.push('              </td>');
            h.push('             <td>');
            h.push('                 <div style="height:1.8cm;width:3.7cm;">');
            h.push('                        <span style="font-size:0.3cm">Fabric Width</span><br/>');
            h.push('                     <b style="font-size:1cm" class="ocrb">'+obj.fabricWidth+'</b>');
            h.push('                 </div>');
            h.push('             </td>');
            h.push('         </tr>');
            h.push('     </tbody>');
            h.push('    </table>');
            h.push('    <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">');
            h.push('        <tr>')

            h.push('                <td style="text-align:center;vertical-align:middle;"><div><div style="font-size:0.3cm;text-align:center;" class="ocrb">'+obj.barCode2Num+'</div><div style="line-height:0;"><img class="barcode" id="barcode2-',tagIndex,'" /></div><div style="font-size:0.3cm;text-align:center;" class="ocrb">'+obj.barCode2Text+'</div></div></td>');

            h.push('                <td style="text-align:center;vertical-align:middle;"><div><div style="font-size:0.3cm;text-align:center;" class="ocrb">'+obj.barCode3Num+'</div><div style="line-height:0;"><img class="barcode" id="barcode3-',tagIndex,'" /></div><div style="font-size:0.3cm;text-align:center;" class="ocrb">'+obj.barCode3Text+'</div></div></td>');
            h.push('        </tr>');
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