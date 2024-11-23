
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<style>
*{
    font-family: 'Lato' !important;
}
  @media print 
  {
      @page {
        size: A4; /* DIN A4 standard, Europe */
        margin: 0;
      }
  }
  @font-face {
    font-family: 'Lato';
    src: url('Lato-Regular.ttf');
  }
  canvas{
    margin:3px;
    border:1px solid;
  }
  .a4{
    width: 21cm;
    background: white;
    min-height: 29.7cm;
  }
</style>
<div class="container p-5 d-print-none">
    <form enctype="multipart/form-data" class="row">
        <input id="upload" type=file name="files[]" class="col-9">
        <a href="format.xlsx" class="btn btn-success btn-sm col-2">format excel</a>
        <a href="#" class="btn btn-light btn-sm col-1" onclick="window.print()">Cetak</a> 
    </form>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
    </ul>

</div>


    <div class="tab-content text-center pt-3" style="background: gray;" id="myTabContent">
    </div>

  <script>










    var ExcelToJSON = function() {
  
      this.parseExcel = function(file) {
        var reader = new FileReader();
  
        reader.onload = function(e) {
          var data = e.target.result;
          var workbook = XLSX.read(data, {
            type: 'binary'
          });
  
          
          workbook.SheetNames.forEach(function(sheetName) {
            // Here is your object

            $("#myTab").append(
                '<li class="nav-item" role="presentation">'+
                '   <button class="nav-link" id="'+sheetName+'-tab" data-bs-toggle="tab" data-bs-target="#'+sheetName+'" type="button" role="tab" aria-controls="'+sheetName+'" aria-selected="true">'+sheetName+'</button>'+
                '</li>'
            );
            
            
            var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
            var json_object = JSON.stringify(XL_row_object);




            $("#myTabContent").append(
                '<div class="tab-pane fade a4 mx-auto" id="'+sheetName+'" role="tabpanel" aria-labelledby="'+sheetName+'-tab">'+
                    '<div class="row">'+
                        '<div  class="col p-0" id="lato-'+sheetName+'">'+

                        '</div>'+
                    '</div>'+
                '</div>'
            );
            cetak(XL_row_object,sheetName);

          })
        };
  
        reader.onerror = function(ex) {
          console.log(ex);
        };
  
        reader.readAsBinaryString(file);
      };
    };
  
    function handleFileSelect(evt) {
  
      var files = evt.target.files; // FileList object
      var xl2json = new ExcelToJSON();
      xl2json.parseExcel(files[0]);
    }


  </script>
  


<script>







function cetak(s,shee){
      s.forEach((data)=>{
        var bCanvas=document.createElement('canvas');
        var canvas = document.createElement("canvas");
        canvas.height=37.795275591*2;
        canvas.width=151.18110236*2;
        canvas.style.width="4cm";
        canvas.style.height="1cm";
        var ctx= canvas.getContext('2d');

        ctx.fillStyle="white";
        ctx.fillRect(0,0,canvas.width,canvas.height);

        ctx.fillStyle="black";
        ctx.font = "14.4pt Lato";
        ctx.fillText('SN : '+data["BARCODE"], 9.6755905512*2, 30.307086614*2);

        ctx.fillStyle="red";
        ctx.fillRect(120*2,26.307086614*2,20.787401575*2,4.7622047244*2)

        ctx.fillStyle="black";

        JsBarcode(bCanvas, data['BARCODE'], {
          format: "CODE128",
          displayValue: false,
          margin: 1,
        });
        
        var image = new Image();
        image.src =bCanvas.toDataURL("image/jpeg", 1.0); 

        image.onload = function() {
          ctx.drawImage(image, 7*2, 7*2, 137.18110236*2,12*2);
        };

        $("#lato-"+shee).append(canvas);

        var ts=document.createElement('canvas');
        ts.height=143;
        ts.width=379;
        ts.style.width="3.2cm";
        ts.style.height="1.2cm";
        var ctxts= ts.getContext('2d');
        ctxts.fillStyle="white";
        ctxts.fillRect(0,0,ts.width,ts.height);
        ctxts.fillStyle="black";
        ctxts.textAlign="center";
        ctxts.font = "bold 20pt Lato";
        ctxts.fillText(data['BARCODE'], ts.width/2, ts.height*0.3);
        ctxts.fillText(data['JENIS MESIN'], ts.width/2, ts.height*0.9);
        ctxts.fillRect(ts.width*0.1,ts.height/2,ts.width*0.8,3);
        $("#lato-"+shee).append(ts);


        var main=document.createElement('canvas');
        main.height=142;
        main.width=295;
        main.style.width="2.5cm";
        main.style.height="1.2cm";
        var ctxmain= main.getContext('2d');
        ctxmain.fillStyle="white";
        ctxmain.fillRect(0,0,main.width,main.height);
        ctxmain.fillStyle="black";
        ctxmain.textAlign="center";
        ctxmain.textBaseline = 'middle';
        ctxmain.font = "bold 28pt Lato";
        ctxmain.fillText(data['MAINBOARD'], main.width/2, main.height/2);
        $("#lato-"+shee).append(main);


        var modul=document.createElement('canvas');
        modul.height=142;
        modul.width=295;
        modul.style.width="2.5cm";
        modul.style.height="1.2cm";
        var ctxmodul= modul.getContext('2d');
        ctxmodul.fillStyle="white";
        ctxmodul.fillRect(0,0,modul.width,modul.height);
        ctxmodul.fillStyle="black";
        ctxmodul.textAlign="center";
        ctxmodul.textBaseline = 'middle';
        ctxmodul.font = "bold 28pt Lato";
        ctxmodul.fillText(data['MODUL'], modul.width/2, modul.height/2);
        $("#lato-"+shee).append(modul);

        var pompa=document.createElement('canvas');
        pompa.height=142;
        pompa.width=295;
        pompa.style.width="2.5cm";
        pompa.style.height="1.2cm";
        var ctxpompa= pompa.getContext('2d');
        ctxpompa.fillStyle="white";
        ctxpompa.fillRect(0,0,pompa.width,pompa.height);
        ctxpompa.fillStyle="black";
        ctxpompa.textAlign="center";
        ctxpompa.textBaseline = 'middle';
        ctxpompa.font = "bold 28pt Lato";
        ctxpompa.fillText(data['POMPA'], pompa.width/2, pompa.height/2);
        $("#lato-"+shee).append(pompa);


        var stepper=document.createElement('canvas');
        stepper.height=142;
        stepper.width=295;
        stepper.style.width="2.5cm";
        stepper.style.height="1.2cm";
        var ctxstepper= stepper.getContext('2d');
        ctxstepper.fillStyle="white";
        ctxstepper.fillRect(0,0,stepper.width,stepper.height);
        ctxstepper.fillStyle="black";
        ctxstepper.textAlign="center";
        ctxstepper.textBaseline = 'middle';
        ctxstepper.font = "bold 28pt Lato";
        ctxstepper.fillText(data['STEPPER'], stepper.width/2, stepper.height/2);
        $("#lato-"+shee).append(stepper);
      
      
        var wims=document.createElement('canvas');
        wims.height=142;
        wims.width=295;
        wims.style.width="2.5cm";
        wims.style.height="1.2cm";
        var ctxwims= wims.getContext('2d');
        ctxwims.fillStyle="white";
        ctxwims.fillRect(0,0,wims.width,wims.height);
        ctxwims.fillStyle="black";
        ctxwims.textAlign="center";
        ctxwims.textBaseline = 'middle';
        ctxwims.font = "bold 28pt Lato";
        ctxwims.fillText(data['WIMS'], wims.width/2, wims.height/2);
        $("#lato-"+shee).append(wims);


          
      });
  }


  document.getElementById('upload').addEventListener('change', handleFileSelect, false);
</script>
