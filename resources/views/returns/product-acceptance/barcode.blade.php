<html>
    <head>
        <script>
            function print() {
                var printContents = document.getElementById('printableAreaBarcode').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = printContents;
            }
        </script>
    </head>
    <body onload="print();" style="font-size: 12px;margin-top: -10px; font-weight: bolder; font-family: Arial">
    <br>
    <br>
    <div id="printableAreaBarcode" style="margin-top: 0;">
        {!! $response !!}
    </div>
    </body>
    </html>
    