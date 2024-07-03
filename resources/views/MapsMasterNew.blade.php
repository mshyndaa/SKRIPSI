<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Simple CMS" />



        <title></title>

        <!-- Bootstrap core CSS -->
        <link href = {{ asset("css/bootstrap.css") }} rel="stylesheet" />
<link  href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
              <!-- Custom styles for this template -->
             <style>
            body{
                width: 100%;
                height:100%;
                padding: 0;
                margin:0;
          background-color:#11142C;
            }


 .modal-header {
  background-color:#11142C;
  color: whitesmoke;
  
}    
.modal-content {
  background-color:lightblue;
  color: red;
  font-weight: bold;
  
}   
.modal-footer {
  background-color:#11142C;
  color: whitesmoke;
  
}   
 
            .fill {
                height: 60%;
            }
            .top7 {
                margin-top:5px;
            }
            /* Number Effect */
            div {
                row-gap: 0.5cm;
            }
            .wifi {
                background: #04d9ff;
            }
.hibob {
                background: #21de54;
            }
            .pc {
                background: #f79545;
            }
            .cctv {
                background: #db2525;
            }
  
.dataTables_wrapper {
    font-family: tahoma;
    font-size: 14px;
    position: relative;
    clear: both;
    *zoom: 1;
    zoom: 1;
}
   .dataTables_filter  {
    color: whitesmoke !IMPORTANT;
}       
 .dataTables_info  {
    color: whitesmoke !IMPORTANT;
}       
table.dataTable thead tr {
  color: whitesmoke !IMPORTANT;
  background-color: #283593  ;
}

table.dataTable tbody tr {
  color: whitesmoke !IMPORTANT;
  background-color:#283593;
}
             .form-control-sm {
    height: 20px;
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem;
}
  

 .page-item .page-link {
    background-color: yellow !important;
    border: 1px solid red;
}
.page-link {
    color: whitesmoke !important;
}
 table td  th{
        word-break: break-word;
        vertical-align: top;
        white-space: normal !important;
          font-size: 0.2rem;

    }
    table.table-bordered> thead > tr > th{
                border:1px solid purple;
                height: 10px;
            }
            table.table-bordered > tbody > tr > td{
                border:1px solid purple;
            }
            select.malldropdown:option {
  
  background: #11142C;
  color: whitesmoke;
  
}
select.malldropdown {
 
  background: #11142C;
  
}

        </style>

    
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
         <script src="{{ asset('js/draggable/plain-draggable.min.js') }}"></script>
         <script src="{{ asset('js/jquery.confirmModal.js') }}"></script>
          <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <body>
        <!-- <div class="alert alert-success alert-dismissable" id="flash-msg">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
<h4><i class="icon fa fa-check"></i><span id="isimessage"></span></h4>
</div>-->
        <div class="container-fluid text-center">
            <!-- Modal -->
  <div class="modal fade" id="flash-msg" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header" style="background-color:grey">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <p id="erroradd" id="error" style="color: red;font-weight: bold;"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
            <!-- Text color class used -->
             <form method="post" action="" id="my_form">
                  @csrf
                  <input type="hidden"  id="valueBtn" name="valueBtn" vale=""">
                  
                   
                   
            <div class="row mt-2">
                <div class="col-1" > <input class="btn btn-primary btn-sm" type="button" onclick="location.href='{{ url('/admin') }}'"  id="btnBack"  value="Back" >
                    </div>    
            <div class="col-9" >

            <span id="floorname_id" style="font-family:Arial; font-size:25px;color:whitesmoke;font-weight:bold;"></span>&nbsp;&nbsp;&nbsp;
            <select id="malldropdown" class="malldropdown" onchange="changesmaps()" style="font-family:Arial; font-size:25px;color:whitesmoke;font-weight:bold;">
                    <optgroup> 
                    </optgroup>
            </select>
            <span id="point_id"></span>
            
            </div>
                <div class="col-1" >
                <br style="line-height:15;" />   
      </div>  
                 <div class="col-1" > <input class="btn btn-primary btn-sm" type="button"  id="btnLogout"  value="Logout" onclick="location.href='{{ url('adminlogout') }}'"></div>  
            
                       </div>
             </form>
             <form  method="post" action="/save" id="newlocation">
              <div class="row  " >
                
                <div class="col-2">&nbsp;</div>
                <div class="col-8 form-group" >
                     <div class="row ">
                        <div class="col-2"><label for="name" id="linkdevice" style="font-family:Arial; font-size:14px;color:whitesmoke;font-weight:bold;">Device Type</label></div>
                        
                        <div class="col-3 d-flex justify">
                            <select id="type" onchange="changetype()" style="height: 20px;">
                                <option value="hibob" selected>HiBob</option>
                                <option value="cctv">CCTV</option>
                                <option value="pc">People Counting</option>
                                <option value="wifi">Wifi</option>

                            </select>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-2"><label for="name" id="linkname" style="font-family:Arial; ffont-size:14px;color:whitesmoke;font-weight:bold;">Device Name</label></div>
                        
                        <div class="col-4"><input type="text" id="name" name="name"  class="form-control form-control-sm mb-2"></div>
                    </div>
                     <div class="row">
                        <div class="col-2"><label for="name" id="linktext" style="font-family:Arial; ffont-size:14px;color:whitesmoke;font-weight:bold;">Device Link</label></td></div>
                        
                        <div class="col-4"><input type="text" id="link" name="link"  class="form-control form-control-sm mb-2"></div>
                   
                        <div class="col-2"><label for="idlinktext" id="idlinktext" style="font-family:Arial; ffont-size:14px;color:whitesmoke;font-weight:bold;">Device ID</label></td></div>
                        
                        <div class="col-4"><input type="text" id="idlink" name="idlink"  maxlength="5" class="form-control form-control-sm mb-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input class="btn btn-primary btn-sm" type="button"  id="btnAdd" value="Add">
                            <input class="btn btn-primary btn-sm" type="button"  id="btnUpdate" value="Update">
                            <input class="btn btn-primary btn-sm" type="button"  id="btnSave" value="Save" >
                            <input class="btn btn-default btn-sm" type="button"  id="btnCancel" value="Cancel" >
                            <input class="btn btn-danger btn-sm" type="button" disabled id="btnDelete" value="Delete">
                        </div>
                    </div>
               {!! csrf_field() !!}
                                <input type="text" id="location" name="location" value="{{$FloorID}}" hidden>
                                <!-- <label for="typeppoint">Type</label> -->
                                <input type="text" id="typeppoint" name="typeppoint" value="hibob" hidden>
                                <input type="text" id="company" name="company" value="{{$CompID}}" hidden>
                                <!-- <label for="x">X Axis</label> -->
                                <input type="hidden" id="x" name="x" >
                                <!-- <br> -->
                                <!-- <label for="y">Y Axis</label> -->
                                <input type="hidden" id="y" name="y" >
                                <input type="hidden" id="actionmap" name="actionmap"/>
                                <!-- <br> -->
                               
                                <label for="idn" id='idtext' hidden>Source ID</label>
                                <input type="hidden" id="idn" name="idn" value="">
                              
                                </form>   
                        <input type='hidden' name='floorId' id='floorId' value=""/>
                        <input type='hidden' name='deleteid' id='deleteid' value=""/>
                        </div>
                <div class="col-2">&nbsp;</div>
                   
            </div>
           
            <div class="row w-88 " >
 
              
                <div class="col-7" id="displayFloor"> <svg version="1.1" id="mysvg" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"
                                                           xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"
                                                           xml:space="preserve" >
                    <image id="mps" width="1903" height="1000" xlink:href="peta/b2.png"
                           href="">
                    </image>    
                    <g  id="maps" onclick="clicked(evt)">
                        <rect class="btn" style="background-color: blue;fill-opacity:0;" id="_x3C_Slice_x3E_" x="0" y="0" fill="blue" width="1903" height="1000"/>
                        <!-- <text x="0" y="875" font-family="Arial" font-size="20" fill="#e8e8e8" >Information :</text>
                        <rect style="background-color: #04d9ff;fill-opacity:1;" x="0" y="894" fill="#04d9ff" width="18" height="18"></rect>
                        <text x="20" y="905" font-family="Arial" font-size="18" fill="#e8e8e8" >:</text>
                        <text x="25" y="905" font-family="Arial" font-size="18" fill="#e8e8e8" >Wifi</text>
                        <rect style="background-color: #f79545;fill-opacity:1;" x="0" y="924" fill="#f79545" width="18" height="18"></rect>
                        <text x="20" y="935" font-family="Arial" font-size="18" fill="#e8e8e8" >:</text>
                        <text x="25" y="935" font-family="Arial" font-size="18" fill="#e8e8e8" >People Counting</text>
                        <rect style="background-color: #db2525;fill-opacity:1;" x="0" y="954" fill="#db2525" width="18" height="18"></rect>
                        <text x="20" y="965" font-family="Arial" font-size="18" fill="#e8e8e8" >:</text>
                        <text x="25" y="965" font-family="Arial" font-size="18" fill="#e8e8e8" >CCTV</text>
                        <rect style="background-color: #21de54;fill-opacity:1;" x="0" y="984" fill="#21de54" width="18" height="18"></rect>
                        <text x="20" y="995" font-family="Arial" font-size="18" fill="#e8e8e8" >:</text>
                        <text x="25" y="995" font-family="Arial" font-size="18" fill="#e8e8e8" >Gateaway - HiBob</text> -->

                    </g>
                 
                    
                    </svg></div>
                <div class="col-5">
                <div class="col-12 table-responsive"">

                    <table class="table table-bordered  dt-responsive " id="ajax-crud-datatable">
           <thead>
              <tr>
                 <th>Id</th>
                <th>Name</th>
                <th>Link</th>
                <th>Type</th>
              </tr>
           </thead>
           <tbody></tbody>
        </table>
                                     </div>   
                    <div clas="col-12">

         <table class="table table-bordered table-dark small">
                        <thead>
                            <tr>
                                <th scope="col" colspan="4">Information</th>
                            </tr>
                            <tr>
                                <th scope="col">Legend</th>
                                <th scope="col">Name</th>
                                <th scope="col">Total Device</th>
                                <th scope="col">Total Device / Floor</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col" class="wifi"></td>
                                <td >Wifi Unifi</td>
                                <td><span id="allwifi"></span></td>
                                <td><span id="floorwifi"></span></td>
                                
                            </tr>
                            <tr>
                                <td scope="col" class="pc"></td>
                                <td >People Counting</td>
                                <td><span id="allpc"></span></td>
                                <td><span id="floorpc"></span></td>
                                
                            </tr>
                            <tr>
                                <td scope="col" class="hibob"></td>
                                <td >Gateway Hibob</td>
                                <td><span id="allhibob"></span></td>
                                <td><span id="floorhibob"></span></td>
                                
                            </tr>
                            <tr>
                                <td scope="col" class="cctv"></td>
                                <td >CCTV</td>
                                <td><span id="allcctv"></span></td>
                                <td><span id="floorcctv"></span></td>
                             
                            </tr>
                        </tbody>
                        <input type='hidden' name='floorId' id='floorId' value=""/>
                    </table>     
                    </div>
                </div>
            </div>
                 <div class="row w-7 " >
                <div class="col-12" >
                   

                </div>
            </div>
        
       </div>        

         <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="color:black">
          
        <div class="modal-body">
            <h5 class="modal-title" style="color: black">This <b>'Device/Gateway'</b> down,failed toconnect </h5>
          <p id="error" style="color: black"></p>
          <p style="color: black">Please check your device or gateway, or trying to reconnect again</p>
          <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
        </div>
        
      </div>
      
    </div>
  </div>
  
</body>
<script>
    var presisiX=0;
    var presisiY=0;
     var loopke=0;
     var isdeleted=1;
     var checkloop=1;
    var index = 0;
    var type = 'hibob';
    var arrId=[];
     const svg=document.getElementById('mysvg');
    var pt=svg.createSVGPoint();
    var arrDeadIdTotal=[];
    var FloorID =0;
    var floor = <?php echo isset($floor) ? json_encode($floor) : 0; ?>;
    // Hibob = #21de54,CCTV = #db2525,People Counting = #f79545,Wifi = #04d9ff
    var color = '#21de54';
    var menu = <?php echo isset($pagesurface) ? json_encode($pagesurface) : 1; ?>;
    var colortext = 'white';
    var colortextalert = 'red';
    var maxmenu = parseInt(floor.length / 4);
    if (parseInt(floor.length % 4) != 0) {
        maxmenu++;
    }
    var menunya="";
for (var i = 0; i < floor.length; i++) {
    menunya +="<option  value='"+floor[i]['id']+"'>"+floor[i]['name']+"</option>";
}
$('#malldropdown')
    .empty()
    .append(menunya);
;
    var colormenuon = 'white';
    var colormenuoff = '#DFE2E2';

    var height = window.screen.availHeight;
    var width = window.screen.availWidth;

    // console.log("Width: "+width+",Height: "+height);

    //   document.getElementById("_x3C_Slice_x3E_").style.height = height
    //    document.getElementById("_x3C_Slice_x3E_").style.width = width

    const now = new Date();
    currentHours = now.getHours();
    currentHours = ("0" + currentHours).slice(-2);

    currentMinutes = now.getMinutes();
    currentMinutes = ("0" + currentMinutes).slice(-2);

    window.onload = function(){
         var totalCCTV = <?php echo isset($cctv) ? json_encode($cctv) : 0; ?>;
            var totalHibob = <?php echo isset($hibobdata) ? json_encode($hibobdata) : 0; ?>;
            var totalPC = <?php echo isset($pcdata) ? json_encode($pcdata) : 0; ?>;
            var totalWifi = <?php echo isset($wifidata) ? json_encode($wifidata) : 0; ?>;
        document.getElementById("allcctv").innerHTML =totalCCTV+" Device";
                document.getElementById("allhibob").innerHTML ="<tspan x='42%' font-weight='bold' font-size='100x'  fill='white' style='font-color:white' >"+totalHibob+" Device</tspan>";
                 document.getElementById("allpc").innerHTML ="<tspan x='42%' font-weight='bold' font-size='100x'  fill='white' style='font-color:white' >"+totalPC+" Device</tspan>";
                 document.getElementById("allwifi").innerHTML ="<tspan x='42%' font-weight='bold' font-size='100x'  fill='white' style='font-color:white' >"+totalWifi+" Device</tspan>";
        $("#btnSave").hide();
            $("#btnCancel").hide();
        
        menus();
        var FloorID = <?php echo isset($FloorID) ? json_encode($FloorID):1; ?>;
        changemaps(FloorID);
    }


    function changetype(){
        var value = document.getElementById('type').value;
        if(value == 'hibob'){
            document.getElementById('typeppoint').value = 'hibob';
            type = 'hibob';
            color = '#21de54';

          /*  document.getElementById('name').type = 'text';
            document.getElementById('name').value = '';

            document.getElementById('idn').type = 'hidden';
            document.getElementById('idn').value = '';

            document.getElementById('link').type = 'text';
            document.getElementById('link').value= '';

            document.getElementById('idtext').style.display = 'none';
          //  document.getElementById('brtext').style.display = 'none';

            document.getElementById('brlink').style.display = 'none';
            document.getElementById('linktext').style.display='block';

            document.getElementById('nametext').style.display = 'block';
           // document.getElementById('brname').style.display = 'block';

            document.getElementById('idlinktext').style.display='block';
            //document.getElementById('bridlink').style.display='none';
            document.getElementById('idlink').type='block';*/
        }else if(value == 'cctv'){
            document.getElementById('typeppoint').value = 'cctv';
            type = 'cctv';
            color = '#db2525';
           /*   document.getElementById('name').type = 'text';
            document.getElementById('name').value = '';

            document.getElementById('idn').type = 'hidden';
            document.getElementById('idn').value = '';

            document.getElementById('link').type = 'text';
            document.getElementById('link').value= '';

            document.getElementById('idtext').style.display = 'none';
           // document.getElementById('brtext').style.display = 'none';

          //  document.getElementById('brlink').style.display = 'none';
            document.getElementById('linktext').style.display='block';

            document.getElementById('nametext').style.display = 'block';
          //  document.getElementById('brname').style.display = 'block';

            document.getElementById('idlinktext').style.display='block';
           // document.getElementById('bridlink').style.display='none';
            document.getElementById('idlink').type='block';
*/
        }else if(value == 'pc'){
            document.getElementById('typeppoint').value = 'pc';
            type = 'pc';
            color = '#f79545';
             /* document.getElementById('name').type = 'text';
            document.getElementById('name').value = '';

            document.getElementById('idn').type = 'hidden';
            document.getElementById('idn').value = '';

            document.getElementById('link').type = 'text';
            document.getElementById('link').value= '';

            document.getElementById('idtext').style.display = 'none';
            document.getElementById('brtext').style.display = 'none';

            document.getElementById('brlink').style.display = 'none';
            document.getElementById('linktext').style.display='block';

            documedragnt.getElementById('nametext').style.display = 'block';
            document.getElementById('brname').style.display = 'block';

            document.getElementById('idlinktext').style.display='block';
            document.getElementById('bridlink').style.display='none';
            document.getElementById('idlink').type='block';
*/
        }else if(value == 'wifi'){
            document.getElementById('typeppoint').value = 'wifi';
            type = 'wifi';
            color = '#04d9ff';
           /*  document.getElementById('name').type = 'text';
            document.getElementById('name').value = '';

            document.getElementById('idn').type = 'hidden';
            document.getElementById('idn').value = '';

            document.getElementById('link').type = 'text';
            document.getElementById('link').value= '';

            document.getElementById('idtext').style.display = 'none';
           // document.getElementById('brtext').style.display = 'none';

          //  document.getElementById('brlink').style.display = 'none';
            document.getElementById('linktext').style.display='block';

            document.getElementById('nametext').style.display = 'block';
           // document.getElementById('brname').style.display = 'block';

            document.getElementById('idlinktext').style.display='block';
          //  document.getElementById('bridlink').style.display='none';
            document.getElementById('idlink').type='block';
*/
        }
    }
    function nexts() {
        if (menu != maxmenu) {
            menu++;
        } else {
            menu = 1;
        }
        menus();
    }

    function prevs() {
        if (menu != 1) {
            menu--;
        } else {
            menu = maxmenu;
        }
        menus();
    }
    function Abort()
    {
    throw new Error('This is not an error. This is just to abort javascript');
    
    }
    function changesmaps(){
        changemaps($("#malldropdown").val());   
    }
    function changemaps(a){
      var idfloor = '';

      $.ajax({
          type: 'GET',
          url: window.location.origin+"/changeadminfloor/"+a,
          beforeSend: function() {
          },
          success: function (response) {
              var data = JSON.parse(response)
              document.getElementById('mps').setAttribute('href', '../'+data[0]['maps_img']);
              document.getElementById('floorname_id').innerHTML = data[0]['sitename'].toString() + ' Floor ' ;
              idfloor = data[0]['id'].toString();
               document.getElementById('location').value = idfloor;
             reloadFloor();
          }
      });

    } 
    function reloadFloor(){
          var totalHibobFloor = 0;
            var totalWifiFloor = 0;
            var totalPCFloor = 0;
            var totalCCTVFloor = 0;
        idfloorReload = document.getElementById('location').value;
        var div = document.getElementById('maps');
        $.ajax({
            type: 'GET',
            url: window.location.origin+"/flooradmin/"+idfloorReload,
            beforeSend: function() {
                div.innerHTML = '';
            },
            success: function (response) {
                var data = JSON.parse(response);
                div.innerHTML += '<rect class="btn" style="background-color: blue;fill-opacity:0;" id="_x3C_Slice_x3E_" x="0" y="0" fill="blue" width="100%" height="100%"/>';
                if(data.length != 0){
                    var newData=[];
                     
                    for(var i = 0;i < data.length;i++){
                        var typenya=data[i]['type'];
                        if(data[i]['type'] == 'hibob'){
                            var x = data[i]['x_axis'];
                            var y = data[i]['y_axis'];
                            var id = data[i]['id'];
                            totalHibobFloor = totalHibobFloor + 1;
                              var id_no = (data[i]['zm_id']!=null?data[i]['zm_id']:"");
                            var ip_addr = (data[i]['link']!=null?data[i]['link']:"");
                            var namedevice = (data[i]['name']!=null?data[i]['name']:"");
                            div.innerHTML += '<circle id="c3_'+id+'" cx="'+x+'" cy="'+y+'" namenya="'+namedevice+'" linknya="'+ip_addr+'"  idnya="'+id_no+'" typenya="'+typenya+'"  r="12" fill="#21de54" onclick="deleteddata('+id+')"></circle>';
                            var newtr="<tr><td>"+id_no+"</td><td>"+namedevice+"</td><td>"+ip_addr+"</td><td>"+typenya+"</td></tr>";
                       //     $("#ajax-crud-datatable tbody").append(newtr);
                         //   div.innerHTML += '<circle id="c1'+index+'" fill="transparent" stroke="#21de54" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="12"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle id="c2'+index+'" fill="transparent" stroke="#21de54" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="10"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle id="c3'+index+'" cx="'+x+'" cy="'+y+'" r="8" fill="#21de54" onclick="deleteddata('+id+')"></circle>';
                            // onclick="hibobclickjs(\''+name+'\')"
                            index++;
                        }else if(data[i]['type'] == 'cctv'){
                            var x = data[i]['x_axis'];
                            var y = data[i]['y_axis'];
                            var id = data[i]['id'];
                            totalCCTVFloor = totalCCTVFloor + 1;
                            var id_no = (data[i]['zm_id']!=null?data[i]['zm_id']:" ");
                            var ip_addr = (data[i]['link']!=null?data[i]['link']:" ");
                            var namedevice = (data[i]['name']!=null?data[i]['name']:" ");
                            div.innerHTML += '<circle id="c3_'+id+'" cx="'+x+'" cy="'+y+'"  linknya="'+ip_addr+'"   idnya="'+id_no+'"  r="12" namenya="'+namedevice+'"  typenya="'+typenya+'" fill="#db2525" onclick="deleteddata('+id+')"></circle>';
                            //div.innerHTML += '<circle  id="c3_'+id+'" cx="'+x+'" cy="'+y+'" namenya="'+namedevice+'" linknya="'+ip_addr+'"  idnya="'+id_no+'"  r="12" fill="#db2525" onclick="deleteddata('+id+')" ></circle>';
                           // div.innerHTML += '<circle id="c1'+index+'" fill="transparent" stroke="#db2525" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="12"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle id="c2'+index+'" fill="transparent" stroke="#db2525" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="10"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle  id="c3'+index+'" cx="'+x+'" cy="'+y+'" r="8" fill="#db2525" onclick="deleteddata('+id+')" onmouseover="inmouse(\'Name: '+id+'\',\''+index+'\')" onmouseout="outmouse(\''+index+'\')"></circle><svg width="300" height="150" x="'+(x+15)+'" y="'+(y+15)+'"  id="pop'+index+'" visibility="hidden"><image width="100%" height="100%" margin="0px" xlink:href="../asset/rectpop.svg"></image><text id="text'+index+'" visibility="hidden" x="10" y="25" font-family="Arial" font-size="18" fill="'+colortext+'"></text></svg>';
                            //  onclick="cctvclick('+id+')"
                            // 
                            var newtr="<tr><td>"+id_no+"</td><td>"+namedevice+"</td><td>"+ip_addr+"</td><td>"+typenya+"</td></tr>";
                            //$("#ajax-crud-datatable tbody").append(newtr);
                            index++;
                        }else if(data[i]['type'] == 'pc'){
                            var x = data[i]['x_axis'];
                            var y = data[i]['y_axis'];
                            var id = data[i]['id'];
                            totalPCFloor = totalPCFloor + 1;
                            var id_no = (data[i]['zm_id']!=null?data[i]['zm_id']:" ");
                            var ip_addr = (data[i]['link']!=null?data[i]['link']:" ");
                            var namedevice = (data[i]['name']!=null?data[i]['name']:" ");
                            div.innerHTML += '<circle  id="c3_'+id+'" cx="'+x+'" cy="'+y+'"  namenya="'+namedevice+'" linknya="'+ip_addr+'"  idnya="'+id_no+'" typenya="'+typenya+'" r="12" fill="#f79545" onclick="deleteddata('+id+')" ></circle>';
                            //div.innerHTML += '<circle id="c1'+index+'" fill="transparent" stroke="#f79545" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="12"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle id="c2'+index+'" fill="transparent" stroke="#f79545" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="10"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle  id="c3'+index+'" cx="'+x+'" cy="'+y+'" r="8" fill="#f79545" onclick="deleteddata('+id+')" onmouseover="inmouse(\'Name: '+data[i]['name']+'\',\''+index+'\')" onmouseout="outmouse(\''+index+'\')"></circle><svg width="300" height="150" x="'+(x+15)+'" y="'+(y+15)+'"  id="pop'+index+'" visibility="hidden"><image width="100%" height="100%" margin="0px" xlink:href="../asset/rectpop.svg"></image><text id="text'+index+'" visibility="hidden" x="10" y="25" font-family="Arial" font-size="18" fill="'+colortext+'"></text></svg>';
                            var newtr="<tr><td>"+id_no+"</td><td>"+namedevice+"</td><td>"+ip_addr+"</td><td>"+typenya+"</td></tr>";
                        //    $("#ajax-crud-datatable tbody").append(newtr);
                            index++;
                        }else if(data[i]['type'] == 'wifi'){
                            var x = data[i]['x_axis'];
                            var y = data[i]['y_axis'];
                            var id = data[i]['id'];
                            totalWifiFloor = totalWifiFloor + 1;
                          var id_no = (data[i]['zm_id']!=null?data[i]['zm_id']:" ");
                            var ip_addr = (data[i]['link']!=null?data[i]['link']:" ");
                            var namedevice = (data[i]['name']!=null?data[i]['name']:" ");
                                                        div.innerHTML += '<circle id="c3_'+id+'" cx="'+x+'" cy="'+y+'"  linknya="'+ip_addr+'"   idnya="'+id_no+'" class="popover-icon" r="12" namenya="'+namedevice+'"  typenya="'+typenya+'" fill="#04d9ff" onclick="deleteddata('+id+')"></circle>';
                            //div.innerHTML += '<circle  id="c3_'+id+'" cx="'+x+'" cy="'+y+'" namenya="'+namedevice+'" linknya="'+ip_addr+'"  idnya="'+id_no+'"  r="12" fill="#04d9ff" onclick="deleteddata('+id+')"></circle>';
    //                                        div.innerHTML += '<circle id="c1'+index+'" fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="12"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle id="c2'+index+'" fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="10"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle  id="c3'+index+'" cx="'+x+'" cy="'+y+'" r="8" fill="#04d9ff" onclick="deleteddata('+id+')"></circle>';
                            // onclick="wificlickjs(\''+id+'\');
                            var newtr="<tr><td>"+id_no+"</td><td>"+namedevice+"</td><td>"+ip_addr+"</td><td>"+typenya+"</td></tr>";
                        //    $("#ajax-crud-datatable tbody").append(newtr);
                            index++;
                        }
                    }
                       document.getElementById("floorhibob").innerHTML =totalHibobFloor+" Device";
                       document.getElementById("floorwifi").innerHTML =totalWifiFloor+" Device";
                       document.getElementById("floorpc").innerHTML =totalPCFloor+" Device";
                       document.getElementById("floorcctv").innerHTML =totalCCTVFloor+" Device";
                    populateDataTable(data);
                }
             
            }
        });
        
        $("#btnDelete").prop('disabled', true);
    }
    function populateDataTable(data) {
        $("#ajax-crud-datatable").DataTable().clear();
        var row = 1;
        $.each(data, function (index, value) {
            $('#ajax-crud-datatable').dataTable().fnAddData( [
                
                value.zm_id,
                value.name,
                value.link,value.type
              ]);

           row++;
        });
    }
    function hibobclickjs(id) {
    $(".popover").hide();
        $.ajax({
            type: 'GET',
            url: window.location.origin + "/hibobadmindata/" + id,
            beforeSend: function () {
            },
            success: function (response) {
               // console.log(response);
                if (response.length != 0) {
                    document.getElementById("point_id").innerHTML = response[0]['nama_gateway'].toString();
                }
                var div = document.getElementById('hibobstatus');
                div.value = '1';
                document.getElementById('hibob').setAttribute('href', "../asset/hibob2.png");
                document.getElementById("hibobrect").innerHTML = '<rect">';

                for (var i = 0; i < response.length; i++) {
                    var y = 40 + (i * 75);
                    var y2 = 55 + (i * 75);
                    var nama = response[i]['nama_staff'];
                    var type = response[i]['tipe_alert'];
                    if (type == 'Late') {
                        var image = 'http://hibob.id:2092/images/?url=' + response[i]['url_photo'];
                        document.getElementById("hibobrect").innerHTML += '<text x="10" y="45" font-size="12px" font-family="Arial" fill="' + colortext + '">' + name + '</text><svg x="10" y="' + y + '" width="55" height="70" fill="red"><image width="55" height="70" margin="0px" xlink:href="' + image + '"></image></svg><text x="70" y="' + y2 + '" font-size="12px" font-family="Arial" fill="' + colortext + '">' + nama + '</text><text x="70" y="' + parseInt(y2 + 15) + '" font-family="Arial" font-size="12px" fill="' + colortextalert + '">' + type + '</text>';
                    } else {
                        var image = 'http://hibob.id:2092/images/?url=' + response[i]['url_photo'];
                        document.getElementById("hibobrect").innerHTML += '<text x="10" y="45" font-size="12px" font-family="Arial" fill="' + colortext + '">' + name + '</text><svg x="10" y="' + y + '" width="55" height="70" fill="red"><image width="55" height="70" margin="0px" xlink:href="' + image + '"></image></svg><text x="70" y="' + y2 + '" font-size="12px" font-family="Arial" fill="' + colortext + '">' + nama + '</text><text x="70" y="' + parseInt(y2 + 15) + '" font-size="12px" font-family="Arial" fill="' + colortext + '">' + type + '</text>';
                    }
                    // <text x="70" y="'+parseInt(y2+30)+'" font-size="12px" fill="'+colortext+'">Alert Type:</text><text x="70" y="'+parseInt(y2+45)+'" font-size="12px" fill="'+colortext+'">'+type+'</text>
                }
                document.getElementById("hibobrect").innerHTML += '</rect>';
            }
        });
    }
    function showDevice(){
    var classnya=$('#dropDownDevice').val();
        // console.log(classnya);
    $('.classNone').hide();
    $('.'+classnya).show();
       //    $('.classNone').hide();
     //    $('.'+classnya).show();
    }
    function wificlickjs(id,pos) {
        
        $.ajax({
            type: 'GET',
            url: window.location.origin + "/wifiadmindatadetail/" + id,
            beforeSend: function () {
            },
            success: function (data) {
                var response = JSON.parse(data);
                document.getElementById("point_id").innerHTML = response[0]['Name'].toString();
                var div = document.getElementById('wifistatus');
                div.value = '1';
                document.getElementById('wifi').setAttribute('href', "../asset/wifi2.png");
               //document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="55%" font-family="Arial" font-size="55px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                                 <!--<text x="30%" y="80%" font-family="Arial" font-size="9px" fill="' + colortext + '">' +<?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text>\n\
                 //                                                <text x="20%" y="90%" font-family="Arial" font-size="15px" fill="' + colortext + '" font-height="bold">' + response[0]['Name'] + '</text>';-->
                document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="55%" font-family="Arial" font-size="55px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                                 <text x="40%" y="80%" font-family="Arial" font-size="12px" fill="' + colortext + '">' + response[0]['Name'] + '</text>\n\
                                                                     <text x="40%" y="90%" font-family="Arial" font-size="10px" fill="' + colortext + '">' + (response[0]['Ip']==null?'':response[0]['Ip']) + '</text>\n\
                                                                   <text x="10%" y="90%" font-family="Arial" font-size="10px" fill="' + colortext + '">' + response[0]['WifiDownload']  + '</text>\n\\n\
                                                                         <line x1="0%" y1="85%" x2="100%" y2="85%" stroke="purple" /> \n\
                                                                       <rect x="55%" y="85%" width="2px" height="10%" fill="purple"></rect>\n\
                                                        <text x="65%" y="90%" font-family="Arial" font-size="10px" fill="' + colortext + '">' + response[0]['WifiUpload']  + '</text>\n\
                                                          <text x="7%" y="95%" font-family="Arial" font-size="10px" fill="' + colortext + '" font-height="bold">Mbps Download</text>\n\
                                                              <text x="62%" y="95%" font-family="Arial" font-size="10px" fill="' + colortext + '" font-height="bold">Mbps Upload</text>';
                if (response[0]['Count'] != 0 || response[0]['Count'] != '0') { 
                    counter("wificount1", 0, parseInt(response[0]['Count']), 1);
                } else {
                    document.getElementById('wifi').value = 0;
                }
            }
        });
        var floorvalue=document.getElementById('floorId').value;

       // showHeatMap(floorvalue,pos);
    }

    function cctvclick(id) {
        $.ajax({
            type: 'GET',
            url: window.location.origin + "/cctvadminchange/" + id,
            beforeSend: function () {
            },
            success: function (response) {
                document.getElementById("point_id").innerHTML = response.toString();
            }
        });
    }

    function pcclickjs(id) {
    //$(".popover").hide();
        $.ajax({
            type: 'GET',
            url: window.location.origin + "/pcadminclick/" + id,
            beforeSend: function () {
            },
            success: function (response) {
               // console.log(response)
                document.getElementById("point_id").innerHTML = response[0]['Name'].toString();
                var count = response[0]['Count'].toString();
                var div = document.getElementById('pcstatus');
                div.value = '1';
                document.getElementById('pc').setAttribute('href', "../asset/pc2.png");
                document.getElementById("pcrect").innerHTML = '<text x="22%" y="25%" font-family="Arial" font-size="14px" fill="' + colortext + '">' +<?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text>\n\
                                                               <text id="pccount" x="15%" y="58%" font-family="Arial" font-size="50px" fill="' + colortext + '" font-weight="bold"></text><text x="30%" y="75%" font-family="Arial" font-size="10px" fill="' + colortext + '">Gate Away Number</text><text x="39%" y="85%" font-family="Arial" font-size="15px" fill="' + colortext + '">' + currentHours + ' : ' + currentMinutes + '</text>';
                if (count < 500) {
                    counter("pccount", 0, count, 1);
                } else {
                    counter("pccount", parseInt(count - 500), count, 1);
                }
            }
        });
    }
    function changemapsbyfloor(id){
     window.location = window.location.origin + "/indexbyfloor/" +id;
    }
    function menus() {
        var firstmenu = parseInt(menu * 4) - 3;
        var lastmenu = parseInt(menu * 4);
        var innerhtml = '';
        innerhtml = '<text x="50%" y="85%" font-family="Arial" font-size="10px" fill="' + colortext + '" onclick="prevs();">Previous</text><text x="80%" y="85%" font-family="Arial" font-size="10px" fill="' + colortext + '" onclick="nexts();">Next</text>';
        for (var i = 0; i < floor.length; i++) {
            if (parseInt(floor[i]['sequence_number']) >= firstmenu && parseInt(floor[i]['sequence_number']) <= lastmenu) {
                if (parseInt(i % 4) == 0) {
                    innerhtml = innerhtml + '<text onclick="changemaps(' + floor[i]['id'] + ');" x="10%" y="40%" font-family="Arial" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
                } else if (parseInt(i % 4) == 1) {
                    innerhtml = innerhtml + '<text onclick="changemaps(' + floor[i]['id'] + ');" x="10%" y="50%" font-family="Arial" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
                } else if (parseInt(i % 4) == 2) {
                    innerhtml = innerhtml + '<text onclick="changemaps(' + floor[i]['id'] + ');" x="10%" y="60%" font-family="Arial" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
                } else if (parseInt(i % 4) == 3) {
                    innerhtml = innerhtml + '<text onclick="changemaps(' + floor[i]['id'] + ');" x="10%" y="70%" font-family="Arial" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
                }
            }
        }

        for (var i = 1; i <= maxmenu; i++) {
            var xposition = 85 - parseInt((maxmenu - i) * 10);
            if (i == menu) {
                innerhtml = innerhtml + '<rect style="fill-opacity:1;" x="' + xposition + '%" y="20%" height="2" width="15" fill="' + colormenuon + '"></rect>';
            } else {
                innerhtml = innerhtml + '<rect style="fill-opacity:0.3;" x="' + xposition + '%" y="20%" height="2" width="15" fill="' + colormenuoff + '"></rect>';
            }
        }

       // document.getElementById("srect").innerHTML = innerhtml;
    }

    function inmouse(a, index1) {
        document.getElementById("pop" + index1).style.visibility = "visible"
        document.getElementById("text" + index1).style.visibility = "visible"
        document.getElementById("text" + index1).innerHTML = a
        document.getElementById("mps").style.filter = 'blur(2px)';
        for (var i = 0; i < index; i++) {
            if (i != index1) {
                document.getElementById("c1" + i).style.filter = 'blur(2px)';
                document.getElementById("c2" + i).style.filter = 'blur(2px)';
                document.getElementById("c3" + i).style.filter = 'blur(2px)';
            }
        }
    }

    function outmouse(index1) {
        document.getElementById("pop" + index1).style.visibility = "hidden"
        document.getElementById("text" + index1).style.visibility = "hidden"
        document.getElementById("mps").style.filter = 'blur(0px)';
        for (var i = 0; i < index; i++) {
            document.getElementById("c1" + i).style.filter = 'blur(0px)';
            document.getElementById("c2" + i).style.filter = 'blur(0px)';
            document.getElementById("c3" + i).style.filter = 'blur(0px)';
        }
    }

    function hibobclick() {
        var div = document.getElementById('hibobstatus');
        // if(div.value == '0'){
        //     div.value = '1';
          document.getElementById('hibob').setAttribute('href', "../asset/hibobNew2.png");
        //     document.getElementById("hibobrect").innerHTML = '<rect">';
        //     for(var i = 0;i < 2; i++){
        //         var y = 40 + (i * 75);
        //         var y2 = 55 + (i * 75);
        //         document.getElementById("hibobrect").innerHTML += '<rect x="10" y="'+y+'" width="55" height="70" fill="red"></rect><text x="70" y="'+y2+'" font-size="12px" fill="'+colortext+'">Hello</text><text x="70" y="'+parseInt(y2+15)+'" font-size="12px" fill="'+colortext+'">Hello</text><text x="70" y="'+parseInt(y2+30)+'" font-size="12px" fill="'+colortext+'">Hello</text><text x="70" y="'+parseInt(y2+45)+'" font-size="12px" fill="'+colortext+'">Hello</text>';
        //     }
        //     document.getElementById("hibobrect").innerHTML += '</rect>';
        // }else{
        var hibob = <?php echo isset($hibob) ? json_encode($hibob) : 0; ?>;
        div.value = '0';
        //  document.getElementById('hibob').setAttribute('href', "../asset/hibobNew1.png");
        //   document.getElementById("hibobrect").innerHTML = '<text x="32%" y="58%" font-family="Arial" font-weight="bold" font-size="60px" fill="'+colortext+'" >'+hibob+'</text><text x="32%" y="75%" font-family="Arial" font-size="16px" fill="'+colortext+'">Total Staff</text>';


        var hibobHouseKeeper = <?php echo isset($hibobcountHK) ? json_encode($hibobcountHK) : 0; ?>;
        var hibobGS = <?php echo isset($hibobcountGS) ? json_encode($hibobcountGS) : 0; ?>;
        var hibobOthers = <?php echo isset($hibobcountOthers) ? json_encode($hibobcountOthers) : 0; ?>;
        var wifiDownload = <?php echo isset($wifiDownload) ? json_encode($wifiDownload) : 0; ?>;
        var wifiUpload = <?php echo isset($wifiUpload) ? json_encode($wifiUpload) : 0; ?>;
        /// console.log(hibob);
        document.getElementById("hibobrect").innerHTML = '<text x="32%" y="55%" font-family="Arial" font-weight="bold" font-size="55px" fill="' + colortext + '" >' + hibob + '</text>\n\
                                                        <text x="27%" y="62%" font-family="Arial" font-size="16px" fill="' + colortext + '">Total Staff</text>\n\
                                                        <text x="15%" y="75%" font-family="Arial" font-size="12px" fill="' + colortext + '">Staff : ' + hibobOthers + '</text>\n\
                                                        <text x="15%" y="82%" font-family="Arial" font-size="12px" fill="' + colortext + '">Cleaning Service : ' + hibobHouseKeeper + '</text>\n\
                                                        <text x="15%" y="89%" font-family="Arial" font-size="12px" fill="' + colortext + '">Engineering : ' + hibobGS + '</text>';
        //iexit;
        document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="55%" font-family="Arial" font-size="55px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                         <text x="18%" y="62%" font-family="Arial" font-size="16px" fill="' + colortext + '">Connected Device</text>\n\
                                                        <text x="10%" y="80%" font-family="Arial" font-size="12px" fill="' + colortext + '">' + wifiDownload + '</text>\n\
\n\                                                         <text x="65%" y="80%" font-family="Arial" font-size="12px" fill="' + colortext + '">' + wifiUpload + '</text>\n\
\n\                                                          <text x="7%" y="90%" font-family="Arial" font-size="12px" fill="' + colortext + '" font-height="bold">Mbps Download</text>\n\
                                                       <text x="62%" y="90%" font-family="Arial" font-size="12px" fill="' + colortext + '" font-height="bold">Mbps Upload</text>';
        document.getElementById("point_id").innerHTML = '';
        var unifi = <?php echo isset($unifi) ? json_encode($unifi) : 0; ?>;
        if (unifi != 0 || unifi != '0') {
            counter("wificount1", 0, parseInt(unifi), 1);
        } else {
            document.getElementById("wificount1").value = 0;
        }
        var pcounting = <?php echo isset($PeopleCounting) ? json_encode($PeopleCounting) : 0; ?>;
        if (pcounting < 500) {
            counter("pccount", 0, pcounting, 1);
        } else {
            counter("pccount", parseInt(pcounting - 500), pcounting, 1);
        }
        // }
    }

    function wificlick() {
        var div = document.getElementById('wifistatus');
        // if(div.value == '0'){
        //     div.value = '1';
        //     document.getElementById('wifi').setAttribute('href', "../asset/wifi2.png");
        //     document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="55%" font-family="Arial" font-size="55px" fill="'+colortext+'" font-weight="bold"></text><text x="30%" y="80%" font-family="Arial" font-size="9px" fill="'+colortext+'">'+<?php echo isset($compname) ? json_encode($compname) : 0; ?>+'</text><text x="30%" y="90%" font-family="Arial" font-size="15px" fill="'+colortext+'" font-height="bold">WIFI UNIFI</text>';
        // }else{
        div.value = '0';
        var wifiDownload = <?php echo isset($wifiDownload) ? json_encode($wifiDownload) : 0; ?>;
        var wifiUpload = <?php echo isset($wifiUpload) ? json_encode($wifiUpload) : 0; ?>;

        document.getElementById('wifi').setAttribute('href', "../asset/wifi1.png");
             document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="55%" font-family="Arial" font-size="55px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                         <text x="18%" y="62%" font-family="Arial" font-size="16px" fill="' + colortext + '">Connected Device</text>\n\
                                                         <rect x="55%" y="74%" width="2px" height="22%" fill="purple"></rect>\n\
                                                        <text x="10%" y="80%" font-family="Arial" font-size="12px" fill="' + colortext + '">' + wifiDownload + '</text>\n\\n\
                                                        <text x="65%" y="80%" font-family="Arial" font-size="12px" fill="' + colortext + '">' + wifiUpload + '</text>\n\
                                                          <text x="7%" y="90%" font-family="Arial" font-size="12px" fill="' + colortext + '" font-height="bold">Mbps Download</text>\n\
                                                       <text x="62%" y="90%" font-family="Arial" font-size="12px" fill="' + colortext + '" font-height="bold">Mbps Upload</text>';

    //    document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="55%" font-family="Arial" font-size="55px" fill="' + colortext + '" font-weight="bold"></text><text x="30%" y="80%" font-family="Arial" font-size="9px" fill="' + colortext + '">' +<?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text><text x="30%" y="90%" font-family="Arial" font-size="15px" fill="' + colortext + '" font-height="bold">WIFI UNIFI</text>';
        var unifi = <?php echo isset($unifi) ? json_encode($unifi) : 0; ?>;
        if (unifi != 0 || unifi != '0') {
            counter("wificount1", 0, parseInt(unifi), 1);
        } else {
            document.getElementById("wificount1").value = 0;
        }
        document.getElementById("point_id").innerHTML = '';
        // }
    }

    function pcclick() {
        var div = document.getElementById('pcstatus');
        // if(div.value == '0'){
        //     div.value = '1';
        //     document.getElementById('pc').setAttribute('href', "../asset/pc2.png");
        //     document.getElementById("pcrect").innerHTML = '<text x="22%" y="25%" font-family="Arial" font-size="14px" fill="'+colortext+'">'+<?php echo isset($compname) ? json_encode($compname) : 0; ?>+'</text><text id="pccount" x="15%" y="58%" font-family="Arial" font-size="50px" fill="'+colortext+'" font-weight="bold"></text><text x="30%" y="75%" font-family="Arial" font-size="10px" fill="'+colortext+'">Gate Away Number</text><text x="39%" y="85%" font-family="Arial" font-size="15px" fill="'+colortext+'">'+currentHours+' : '+currentMinutes+'</text>';
        //     document.getElementById("point_id").innerHTML = '';
        //     counter("pccount",parseInt(900-700),900,1);
        // }else{
        var pcounting = <?php echo isset($PeopleCounting) ? json_encode($PeopleCounting) : 0; ?>;
        div.value = '0';
        document.getElementById('pc').setAttribute('href', "../asset/pc1.png");
        document.getElementById("pcrect").innerHTML = '<text x="22%" y="25%" font-family="Arial" font-size="14px" fill="' + colortext + '">' +<?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text><text id="pccount" x="15%" y="58%" font-family="Arial" font-size="50px" fill="' + colortext + '" font-weight="bold"></text><text x="33%" y="75%" font-family="Arial" font-size="10px" fill="' + colortext + '">People Counting</text><text x="39%" y="85%" font-family="Arial" font-size="15px" fill="' + colortext + '">' + currentHours + ' : ' + currentMinutes + '</text>';
        document.getElementById("point_id").innerHTML = '';
        counter("pccount", parseInt(pcounting - 500), pcounting, 1);
        // }
    }

    function counter(id, start, end, duration) {
        if (end == 0) {
            document.getElementById(id).innerHTML = 0;
        } else {
            let obj = document.getElementById(id),
                    current = start,
                    range = end - start,
                    increment = end > start ? 1 : -1,
                    step = Math.abs(Math.floor(duration / range)),
                    timer = setInterval(() => {
                        current += increment;
                        obj.innerHTML = current;
                        if (current == end) {
                            clearInterval(timer);
                        }
                    }, step);
        }

    }
    function showHeatMap(a,iddevice){


        var div = document.getElementById('maps');
      //  var div2 = document.getElementById('maps2');
        $.ajax({
            type: 'GET',
            url: window.location.origin+"/heatdata/"+a,
            beforeSend: function() {

            },
            success: function (data) {
            div.innerHTML = '';
        //        div2.innerHTML = '';
                if(data.length != 0){
                    document.getElementById('mps').setAttribute('href', '../'+data[0]['maps_img']);
                    for(var i = 0;i < data.length;i++){
                        if (data[i]['tipe'] == 'hibob') {
                                    totalHibobFloor = totalHibobFloor + 1;
                                      index++;
                                } else if (data[i]['tipe'] == 'cctv') {
                                       // onmouseover="inmouse(\'Name: '+data[i]['name']+'\',\''+index+'\')" onmouseout="outmouse(\''+index+'\')"<svg width="300" height="150" x="'+(x+15)+'" y="'+(y+15)+'"  id="pop'+index+'" visibility="hidden"><image width="100%" height="100%" margin="0px" xlink:href="../asset/rectpop.svg"></image><text id="text'+index+'" visibility="hidden" x="10" y="25" font-family="Arial" font-size="18" fill="'+colortext+'"></text></svg>
                                    index++;
                                } else if (data[i]['tipe'] == 'pc') {
                                         //  onmouseover="inmouse(\'Name: '+data[i]['name']+'\',\''+index+'\')" onmouseout="outmouse(\''+index+'\')"></circle><svg width="300" height="150" x="'+(x+15)+'" y="'+(y+15)+'"  id="pop'+index+'" visibility="hidden"><image width="100%" height="100%" margin="0px" xlink:href="../asset/rectpop.svg"></image><text id="text'+index+'" visibility="hidden" x="10" y="25" font-family="Arial" font-size="18" fill="'+colortext+'"></text></svg>
                                    index++;
                                } else if (data[i]['tipe'] == 'wifi') {
                                   // console.log(totalWifiFloor);
                                   var x = data[i]['x_axis'];
                        var y = data[i]['y_axis'];
                         var ip_addr = (data[i]['link']!=null?data[i]['link']:'');
                         var namedevice = (data[i]['name']!=null?data[i]['name']:'');
                        var count = parseInt(data[i]['count']);
                        if(count > 0 && count <= 7){
                            var color = 'green';
                        }else if(count > 7 && count <= 15){
                            var color = 'yellow';
                        }else if(count > 15){
                            var color = 'red';
                        }else{
                            var color = 'green';
                        }
                        let str = index.toString();
                    // console.log(str.substr(1));
                   //   console.log(iddevice);
                        div.innerHTML += '<a data-toggle="popover" id="pop' + str.substr(1) + '"  class="popover-icon" data-container="body" title="Wifi" data-content="'+namedevice+'<br>'+ip_addr+'" data-placement="right" data-trigger="hover"><circle style="filter: blur(30px);" id="c1'+index+'" cx="'+x+'" cy="'+y+'" r="70" fill="'+color+'"></circle></a>';
                        div.innerHTML += '<circle id="c1'+index+'" cx="'+x+'" cy="'+y+'" r="8" fill="#04d9ff"></circle>';
                      // if(str.substr(1)==iddevice)

                        index++;
                                }

                    }
                }
                 $('#pop'+iddevice).popover('show');
            }
        });

    }
    
    function clicked(evt){
       console.log("aq");
        if(width == 1920 && height == 1080){
            var div = 0.605;
        }else if(width == 1920 && height == 1032){
            var div = 0.605;
        }else if(width == 1680 && height == 1002){
            var div = 0.605;
        }else if(width == 1600 && height == 852){
            var div = 1.726;
        }else if(width == 1440 && height == 852){
            var div = 1.5715;
        }else if(width == 1400 && height == 1002){
            var div = 1.528;
        }else if(width == 1366 && height == 720){
            var div = 1.4725;
        }else if(width == 1280 && height == 976){
            var div = 1.395;
        }else if(width == 1280 && height == 752){
            var div = 1.39575;
        }else if(width == 1280 && height == 720){
            var div = 1.378;
        }else if(width == 1280 && height == 672){
            var div = 1.376;
        }else if(width == 1024 && height == 720){
            var div = 1.117;
        }else if(width == 800 && height == 552){
            var div = 0.8725;
        }else{
            var div = 1;
        }
        var e = evt.target;
        if($("#actionmap").val()=='add'){
        const svg=document.getElementById('mysvg');
        console.log("a");
        if(document.getElementById('x').value==''){    
            console.log("ab");
            var dim = e.getBoundingClientRect();
            var x =(evt.clientX - dim.left);
            var y = (evt.clientY - dim.top);
            pt.x=evt.clientX;
            pt.y=evt.clientY;
            var cursorpt=pt.matrixTransform(svg.getScreenCTM().inverse());
            console.log("ac");
            x=cursorpt.x;
            y=cursorpt.y;
            var div = document.getElementById('maps');
            div.innerHTML += '<circle id="c1'+index+'" fill="transparent" stroke="'+color+'" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="12"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle id="c2'+index+'" fill="transparent" stroke="'+color+'" stroke-width="0.5" cx="'+x+'" cy="'+y+'" r="10"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle  id="c3'+index+'" cx="'+x+'" cy="'+y+'" r="8" fill="'+color+'" </circle>';
            // onmouseover="inmouse(\'Hello\',\''+index+'\')" onmouseout="outmouse(\''+index+'\')"><svg width="300" height="150" x="'+(x+15)+'" y="'+(y+15)+'"  id="pop'+index+'" visibility="hidden"><image width="100%" height="100%" margin="0px" xlink:href="asset/rectpop.svg"></image><text id="text'+index+'" visibility="hidden" x="10" y="25" font-family="Arial" font-size="18" fill="'+colortext+'"></text></svg>
            index++;
            document.getElementById('x').value = x;
            document.getElementById('y').value = y;
            }
     
        $("#btnDelete").prop('disabled', true);
        }
    }
   function deleteddata(id){
       console.log("(zxxxdfdfdf");
       if(isdeleted==1){
       
            $("#btnDelete").prop('disabled', false);
        }
        console.log(id);
        console.log($('#c3_'+id).attr('typenya'));
        x_val = $('#c3_'+id).attr('cx');
         y_val = $('#c3_'+id).attr('cy');
             
                  $("#x").val(x_val);
            $("#y").val(y_val);
        var name = $('#c3_'+id).attr('namenya');
        var  link= $('#c3_'+id).attr('link');
        var  idlink= $('#c3_'+id).attr('idnya');
         var  type= $('#c3_'+id).attr('typenya');
        console.log("x val"+x_val);
        $("#name").val(name);
        $("#link").val(link);
        $("#idlink").val(idlink);
        $("#type").val(type);
        $("#deleteid").val(id);
        console.log("y val"+y_val);
        if($("#actionmap").val()=='update')
        makeDrag(id);
         //   document.getElementById("mydiv").removeAttribute("hidden");
          //  document.getElementById("deleteid").value = id;
     }
      

    function makeDrag(id){
        if(isdeleted!=2){
            isdeleted=2;
            draggable = new PlainDraggable(document.getElementById('c3_'+id));
            console.log("AAAA");
            draggable.onMove = function(newPosition) {
            console.log("testmove")
            console.log(newPosition.left);
            console.log(newPosition.top);
            pt.x = newPosition.left;
            pt.y = newPosition.top;
            console.log("baru" + pt.x  + ", " + pt.y + ")");
         //The cursor point, translated into svg coordinates
            //var cursorpt + ", " + pt.y + ")");
            //  console.log("(baru=" + cursorpt.x + ", " + cursorpt.y + ")");
         //The cursor point, translated into svg coordinates
            var cursorpt =  pt.matrixTransform(svg.getScreenCTM().inverse());
            console.log("(xxxxx" + cursorpt.x + ", " + cursorpt.y + ")");

           };
            draggable.onDragEnd = function(newPosition) {
            console.log("testDragEnd");
            pt.x = newPosition.left;
            pt.y = newPosition.top;
            console.log("baru" + pt.x  + ", " + pt.y + ")");
         //The cursor point, translated into svg coordinates
            //var cursorpt + ", " + pt.y + ")");
            //  console.log("(baru=" + cursorpt.x + ", " + cursorpt.y + ")");
         //The cursor point, translated into svg coordinates
            var cursorpt =  pt.matrixTransform(svg.getScreenCTM().inverse());
            console.log("(zxxx" + cursorpt.x + ", " + cursorpt.y + ")");
            $("#x").val(cursorpt.x-presisiX+12);
            $("#y").val(cursorpt.y+presisiY+12);
            isdeleted=0;

            $("#btnDelete").prop('disabled', true);
            };
            draggable.onDragStart = function(pointerXY) {
            console.log("teststart");
            console.log(pointerXY);
            pt.x = pointerXY.clientX;
            pt.y = pointerXY.clientY;
            console.log("baru" + pt.x  + ", " + pt.y + ")");
         //The cursor point, translated into svg coordinates
            //var cursorpt + ", " + pt.y + ")");
            //  console.log("(baru=" + cursorpt.x + ", " + cursorpt.y + ")");
         //The cursor point, translated into svg coordinates
            var cursorpt =  pt.matrixTransform(svg.getScreenCTM().inverse());
            presisiX=cursorpt.x-x_val;
            presisiY=cursorpt.y-y_val;
            console.log("(zzzzz" + cursorpt.x + ", " + cursorpt.y + ")");
            document.getElementById("deleteid").value = id;

            };
        }
    }
    function setNewLocation(){
        const svg=document.getElementById('mysvg');
        var pt=svg.createSVGPoint();
        var dim = e.getBoundingClientRect();
        var x =(evt.clientX - dim.left);
        var y = (evt.clientY - dim.top);
        pt.x=evt.clientX;
        pt.y=evt.clientY;
        var cursorpt=pt.matrixTransform(svg.getScreenCTM().inverse());
    }
    function deldat(){
         document.getElementById("mydiv").setAttribute("hidden", "hidden");
        id = document.getElementById("deleteid").value;
        $.ajax({
            type: 'POST',
            url: '/deletedata',
            data: $('#newlocation').serialize(),
            dataType: 'json',
            success: function(response) {
                // Handle the response message
                reloadFloor();
                $('#error').html(response.message);
                $("#flash-msg").modal("show");
            },
            error: function(xhr, status, error) {
                // Handle errors if needed
                console.error(xhr.responseText);
            }
        });

    }
    function back(){
        document.getElementById('my_form').action = "backdashboard";
        document.getElementById('my_form').submit();

    }
function logout(){
    window.location.href = "adminlogout";
    //document.getElementById('my_form').action = "adminlogout";
      //  document.getElementById('my_form').submit();

    }
    function showAddUpdate(){
          $("#btnUpdate").hide();
            $("#btnDelete").hide();
            $("#btnAdd").hide();
            $("#btnSave").show();
            $("#btnCancel").show();
        }
        function hideAddUpdate(){
            $("#btnUpdate").show();
            $("#btnDelete").show();
            $("#btnAdd").show();
            $("#btnSave").hide();
            $("#btnCancel").hide();
            $("#name").val('');
            $("#idlink").val('');
            $("#link").val('');
        }
    </script>
  
    <script>
      /* $('form').on('submit', function(event) {
    event.preventDefault();
    $('#hiddenInput').val(someVariable); //perform some operations
    this.submit(); //now submit the form
}); */          
  $(document).on("mouseover", ".popover-icon", function(e) {
    //  console.log(this.id);
    idnya=this.id;
  // const exampleEl = document.getElementById('pop15');
    $('#'+idnya).popover({html:true});
    $('#'+idnya).popover('show');
  
//const popover = new coreui.Popover(exampleEl, options)
//60000 1menit
});
$(document).on('click',".popover-icon",function(){
 //console.log(this.id);
    idnya=this.id;
   const exampleEl = document.getElementById('pop15');
   $('#'+idnya).popover({html:true});
   $('#'+idnya).popover('hide');
  
});
$(document).on("mouseout", ".popover-icon", function(e) {
      //console.log(this.id);
    idnya=this.id;
  // const exampleEl = document.getElementById('pop15');
    $('#'+idnya).popover({html:true});
    $('#'+idnya).popover('hide');
  
//const popover = new coreui.Popover(exampleEl, options)
});

        
jQuery.fn.extend({
    myShow: function () {
        return this.attr('aria-hidden', 'false').show()
    },
    myHide:function(){
        return this.attr('aria-hidden', 'true').hide()
    }
});

    $(document).ready(function() {
         //$('#ajax-crud-datatable').DataTable();
      $('#ajax-crud-datatable').dataTable({   
        
            "bLengthChange" : false,
        "ordering": false,
  
        
});
        $('#btnSave').click(function(e) {
             var name=$("#name").val();
             console.log("s"+name+"b");
             name = name.trim();
             var link=$("#link").val();
             console.log("s"+name+"b");
             link = link.trim();
             var idlink=$("#idlink").val();
             console.log("s"+name+"b");
             idlink = idlink.trim();

             console.log("s2"+name+"3b");
            
              if($("#type").val().trim()==''){
                $('#erroradd').html("Please Select Device Type");
                    $("#flash-msg").modal("show"); 
           }else if(name==''){
                $('#erroradd').html("Please Input Device Name");
                    $("#flash-msg").modal("show"); 
           }else if(link==''){
                $('#erroradd').html("Please Input Device Link");
                    $("#flash-msg").modal("show"); 
           }else if(idlink==''){
                $('#erroradd').html("Please Input Device ID");
                    $("#flash-msg").modal("show"); 
           }else if($("#x").val()=='' && $("#deleteid").val()==''){
                $('#erroradd').html("Please Put Location");
                    $("#flash-msg").modal("show");
               
                    
           }
           else{
            //e.preventDefault();
            
            var process="";
            if($("#deleteid").val()!='')
                    process="/update";
            else
                process="/save";
            // Serialize the form data
          // const formData = new FormData(form);
            // Send an AJAX request
            $.ajax({
                type: 'POST',
                url: process,
                data: $('#newlocation').serialize(),
                dataType: 'json',
                success: function(response) {
                    // Handle the response message
                    reloadFloor();
                    $('#erroradd').html(response.message);
                    $("#flash-msg").modal("show");
                    hideAddUpdate();
                    $("#actionmap").val("");
            document.getElementById('x').value="";
            document.getElementById('y').value="";
            isdeleted=1;
                },
                error: function(xhr, status, error) {
                    // Handle errors if needed
                    console.error(xhr.responseText);
                }
            });
        }
        });
        $("#btnCancel").click(function(e) {
            reloadFloor();
            hideAddUpdate();
            $("#actionmap").val("");
            document.getElementById('x').value="";
            document.getElementById('y').value="";
            isdeleted=1;
        });
         $("#btnAdd").click(function(e) {
            showAddUpdate();
            document.getElementById('x').value="";
            $("#actionmap").val('add');
          
            
        });
         $("#btnUpdate").click(function(e) {
            showAddUpdate();
            $("#actionmap").val('update');
          
            
        });
        $('#btnDelete').click(function(e) {
            //e.preventDefault();
              $.confirmModal('Are you sure to delete this?', function(el) {
        console.log("Ok was clicked!");
        var process="";
             id = document.getElementById("deleteid").value;
           console.log("test"+$("#actionmap").val());
         
               
        //  exit;
            // Serialize the form data
          // const formData = new FormData(form);id_no
            // Send an AJAX request
            $.ajax({
                type: 'POST',
                url: "/deletedata",
                data: $('#newlocation').serialize(),
                dataType: 'json',
                success: function(response) {
                    // Handle the response message
                    reloadFloor();
                    $('#erroradd').html(response.message);
                    $("#flash-msg").modal("show");
                    hideAddUpdate();
                },
                error: function(xhr, status, error) {
                    // Handle errors if needed
                    console.error(xhr.responseText);
                }
            });
        });
        //do delete operation
      });
            
    });



</script>
<!--
function removePopOver(id) {
      id = "#" + id;
      $(id).popover('dispose'); // JQuery > 4.1
      // $(id).popover('destroy'); // JQuery < 4.1
}-->
</html><!-- comment -->
