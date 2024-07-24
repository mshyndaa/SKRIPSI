<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Simple CMS" />
        <title>Mall Dashboard - </title>
        <link href = {{ asset("css/bootstrap.css") }} rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;600&display=swap" rel="stylesheet">
        <style>
            body{
                width: 100%;
                height:100%;
                padding: 0;
                margin:0;
                background-color:#11142C;
                font-family: 'Poppins', sans-serif;
            }
            .header {
                font-weight: 600;
            }
            .regular {
                font-weight: 400;
            }
            .semi {
                font-weight: 200;
            }
            .light {
                font-weight: 100;
            }
            .modal-header {
                background-color:#11142C;
                color: whitesmoke;

            }
            .modal-content {
                background-color:lightblue;
                color: whitesmoke;

            }
            .modal-footer {
                background-color:#11142C;
                color: whitesmoke;

            }

            .fill {
                height: 60%;
            }
            .top7 {
                margin-top:7px;
            }
            div {
                row-gap: 0.5cm;
            }
            .wifi {
                background: #04d9ff;
            }
            .pc {
                background: #f79545;
            }


            table.table-bordered> thead > tr > th{
                border:1px solid purple;
            }
            table.table-bordered > tbody > tr > td{
                border:1px solid purple;
            }
            #menuBar img{
                max-width: 50%;
                max-height: 100%;
                display: block;
            }
            .btn{
                background-color: transparent;
                color: white;
            }
                
            .content-wrapper {
                margin-bottom: 60px; /* Adjust based on footer height */
                padding-bottom: 20px; /* Adjust for bottom padding */
            }
            footer {
                color: white;
                background-color: #1d2039;
                padding: 10px 0;
                text-align: center;
                width: 100%;
                position: fixed;
                bottom: 0;
                z-index: 1000; /* Ensure footer is above other content */
            }

        </style>
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    </head>
    <body>
        <div class="container-fluid text-center">
            <div class="row mb-2" style="background-color: #1d2039;">
                <div class="col-7 text-left text-uppercase header mt-2" >
                    <span id="floorname_id" style="font-size:25px;color:whitesmoke;font-weight:bold;"></span>
                    <span id="point_id" style="color:whitesmoke"></span>
                </div>
                <div class="col-3 d-flex justify-content-end" style="margin-top: 0.1rem;">
                    <select  style="background-color:transparent; border-color:transparent;color:white" id="dropDownDevice" onchange="showDeviceData()">
                        <option value="classNone">All Device</option>
                        <option value="classWifi">Wifi Unifi</option>
                        <option value="classPC">People Counting</option>
                    </select>
                </div>
                <div class="col-2 text-left  d-flex justify-content-end" >
                    <input class="btn" style="margin-top:0.1rem;text-transform: uppercase; font-weight:bold" type="button" onclick="location.href ='{{ url('/home') }}'"  id="btnBack" value="Back" >
                    <form method="POST" style="margin-top:0.3rem;" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="text-transform: uppercase; font-weight:bold" class="btn">Logout</button>
                    </form>
                </div>
            </div>
            <div class="content-wrapper"> 
            <div class="row w-92 top7 mt-4" >
                <div class="col-2">
                    <div class="row top7">
                        <div class="col-12 ">
                            <svg version="1.1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 200"xml:space="preserve">
                            <image overflow="visible" width="200" height="200" xlink:href="../asset/survace1.png">
                            </image>
                            <g id="srect"></g>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-8" id="displayFloor"> <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve" >
                    <image id="mps" width="1903" height="1000" xlink:href="peta/b2.png" href=""></image>
                    <g id="maps"></g>
                    </svg>
                </div>
                <div class="col-2">
                    <div class="row top7">
                        <div class="col-12 ">
                            <svg version="1.1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 200"xml:space="preserve">
                            <image id="wifi" overflow="visible" width="200" height="200" xlink:href="../asset/wifi1.png"></image>
                            <g onclick="wificlick();">
                            <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="200" height="200"/>
                            </g>
                            <g id="wifirect"></g>
                            </svg>
                            <input type="hidden" id="wifistatus" value="0">
                        </div>
                        <div class="col-12">
                            <svg version="1.1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 200"xml:space="preserve">
                            <image id="pc" overflow="visible" width="200" height="200" xlink:href="../asset/pc1.png"></image>
                            <g onclick="pcclick();">
                            <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="200" height="200"/>
                            </g>
                            <g id="pcrect"></g>
                            </svg>
                            <input type="hidden" id="pcstatus" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5 d-flex justify-content-center" style="padding-left: 5%; padding-right:5%"  >
                    <table id="menuBar" class="table table-bordered table-sm" style="color: white; margin-top:5%">
                        <thead>
                            <tr style="height:10%">
                            <th scope="col" colspan="5">Information</th>
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
                        </tbody>
                        <input type='hidden' name='floorId' id='floorId' value=""/>
                    </table>
            </div>
        </div>
        </div>
        <footer style="color: white; background-color: #1d2039; margin-top: 2%; padding: 1px;">
            <p style="text-align: center; padding-top:1%">&copy; Mall Dashboard 2024 | Bedria Mashyanda Maail - 2440027303</p>
    </footer>
    </body>
    <script>
        var loopke = 0;
        var checkloop = 1;
        var index = 0;
        var type = 'pc';
        var arrId = [];
        var arrDeadIdTotal = [];
        var FloorID = 0;
        var floor = <?php echo isset($floor) ? json_encode($floor) : 0; ?>;
        var color = '#f79545';
        var menu = <?php echo isset($pagesurface) ? json_encode($pagesurface) : 1; ?>;
        var colortext = 'white';
        var colortextalert = 'red';
        var maxmenu = parseInt(floor.length / 4);
        if (parseInt(floor.length % 4) != 0) {
        maxmenu++;
        }

        var colormenuon = 'white';
        var colormenuoff = '#DFE2E2';
        var height = window.screen.availHeight;
        var width = window.screen.availWidth;
        const now = new Date();
        currentHours = now.getHours();
        currentHours = ("0" + currentHours).slice( - 2);
        currentMinutes = now.getMinutes();
        currentMinutes = ("0" + currentMinutes).slice( - 2);
        window.onload = function () {
        var wifiDownload = <?php echo isset($wifiDownload) ? json_encode($wifiDownload) : 0; ?>;
        var wifiUpload = <?php echo isset($wifiUpload) ? json_encode($wifiUpload) : 0; ?>;
        var totalPC = <?php echo isset($pcdata) ? json_encode($pcdata) : 0; ?>;
        var totalWifi = <?php echo isset($wifidata) ? json_encode($wifidata) : 0; ?>;
        var count = totalPC.toString();
        xpospc=50-5*count.length;
        document.getElementById("allpc").innerHTML = "<tspan x='42%' font-weight='bold' font-size='100x'  fill='white' style='font-color:white' >" + totalPC + " Device</tspan>";
        document.getElementById("allwifi").innerHTML = "<tspan x='42%' font-weight='bold' font-size='100x'  fill='white' style='font-color:white' >" + totalWifi + " Device</tspan>";
        document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="50%" font-family="Poppins" font-size="55px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                            <text x="18%" y="60%" font-family="Poppins" font-size="14px" fill="' + colortext + '">Connected Device</text>\n\
                                                            <text x="10%" y="82%" font-family="Poppins" font-size="12px" fill="' + colortext + '" id="wifidownload">' + wifiDownload + '</text>\n\\n\
                                                            <text x="65%" y="82%" font-family="Poppins" font-size="12px" fill="' + colortext + '" id="wifiupload">' + wifiUpload + '</text>\n\
                                                            <text x="7%" y="90%" font-family="Poppins" font-size="9px" fill="' + colortext + '" font-height="bold">Mbps Download</text>\n\
                                                           <text x="62%" y="90%" font-family="Poppins" font-size="9px" fill="' + colortext + '" font-height="bold">Mbps Upload</text>';
        document.getElementById("pcrect").innerHTML = '<text x="14%" y="25%" font-family="Poppins" font-size="14px" fill="' + colortext + '">' +<?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text>\n\
                                                          <text id="pccount" x="10%" y="58%" font-family="Poppins" font-size="40px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                           <text x="33%" y="75%" font-family="Poppins" font-size="10px" fill="' + colortext + '">People Counting</text>\n\
                                                           <text x="39%" y="85%" font-family="Poppins" font-size="15px" fill="' + colortext + '">' + currentHours + ' : ' + currentMinutes + '</text>';
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

        menus();
        FloorID = <?php echo isset($FloorID) ? json_encode($FloorID) : 1; ?>;
        document.getElementById('floorId').value = FloorID;
        var classDeviceSelected = <?php echo isset($typedevice) ? json_encode($typedevice) : 'classNone'; ?>;
        console.log("sdsd"+classDeviceSelected);
        $('#dropDownDevice').val(classDeviceSelected);
         if(classDeviceSelected!='classWifi')checkloop=1; else checkloop=2;
        changemaps(FloorID);
        loadAllDataWifi(FloorID);
        setTimeout(refreshData, 30000);

        }

        function changetype() {
            var value = document.getElementById('type').value;
            if (value == 'pc') {
            document.getElementById('typeppoint').value = 'pc';
            type = 'pc';
            color = '#f79545';
            document.getElementById('name').type = 'text';
            document.getElementById('name').value = '';
            document.getElementById('idn').type = 'text';
            document.getElementById('link').type = 'hidden';
            document.getElementById('idn').value = '';
            document.getElementById('link').value = '';
            document.getElementById('idtext').style.display = 'block';
            document.getElementById('brtext').style.display = 'block';
            document.getElementById('brlink').style.display = 'none';
            document.getElementById('linktext').style.display = 'none';
            document.getElementById('nametext').style.display = 'block';
            document.getElementById('brname').style.display = 'block';
            } else if (value == 'wifi') {
            document.getElementById('typeppoint').value = 'wifi';
            type = 'wifi';
            color = '#04d9ff';
            document.getElementById('name').type = 'text';
            document.getElementById('name').value = '';
            document.getElementById('idn').type = 'text';
            document.getElementById('link').type = 'hidden';
            document.getElementById('idn').value = '';
            document.getElementById('link').value = '';
            document.getElementById('idtext').style.display = 'none';
            document.getElementById('brtext').style.display = 'none';
            document.getElementById('brlink').style.display = 'none';
            document.getElementById('linktext').style.display = 'none';
            document.getElementById('nametext').style.display = 'block';
            document.getElementById('brname').style.display = 'block';
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
        function refreshData() {
            var pos=0;
            var floorvalue=document.getElementById('floorId').value;
            var div = document.getElementById('maps');
              if(checkloop=='0') checkloop=1;
            loopke++;
            console.log("check="+checkloop);
            var idfloor = '';
            var totalWifiFloor = 0;
            var totalPCFloor = 0;
            var totalDeadWifiFloor = 0;
            var totalDeadPCFloor = 0;
            var displayAwal = 0;
            var blinkAnimated = 1;
            if(checkloop==1){
                $.ajax({
                type: 'GET',
                        url: window.location.origin + "/floorcondition/" + FloorID,
                        beforeSend: function () {
                        },
                        success: function (response) {
                            if(checkloop==1){
                            $(".popover").popover('hide');
                            var data = response['data'];
                            var infoDeviceMati = response['chgDeviceStatus'];

                            if (data.length != 0) {
                            div.innerHTML = '';
                            for (var i = 0; i < data.length; i++) {
                            if (displayAwal == 0)
                                    arrId.push(data[i]['id']);
                            if (data[i]['isalive'] == 0) {
                            arrDeadIdTotal.push(data[i]['id']);
                            }if (data[i]['type'] == 'pc') {
                            totalPCFloor = totalPCFloor + 1;
                            var x = data[i]['x_axis'];
                            var y = data[i]['y_axis'];
                            var id = data[i]['id'];
                            var id_no = (data[i]['zm_id'] != null?data[i]['zm_id']:"");
                            var ip_addr = (data[i]['link'] != null ? data[i]['link'] : '');
                            var namedevice = (data[i]['name'] != null ? data[i]['name'] : '');
                            if (data[i]['isalive'] == 0)
                            {
                            totalDeadPCFloor = totalDeadPCFloor + 1;
                            div.innerHTML += '<a data-toggle="popover" id="pop_' + id + '"  class="popover-icon" data-container="body" title="' + namedevice + '" data-content="' + id_no + '<br>' + ip_addr + '" data-placement="right" data-trigger="hover"><circle class="classPC classNone" id="c1_' + id + '"  fill="transparent" stroke="#f79545" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12" onclick="pcclickjs(' + id + ')"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="' + blinkAnimated + '" /></circle><circle class="classPC classNone" id="c2_' + id + '"   fill="transparent" stroke="#f79545" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10" onclick="pcclickjs(' + id + ')"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="' + blinkAnimated + '" /></circle><circle  class="classPC classNone" id="c3_' + id + '"   cx="' + x + '" cy="' + y + '" r="8" fill="#f79545" onclick="pcclickjs(' + id + ')"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="' + blinkAnimated + '" /></circle></a>';
                            } else {
                            div.innerHTML += '<a data-toggle="popover" id="pop_' + id + '"  class="popover-icon" data-container="body" title="' + namedevice + '" data-content="' + id_no + '<br>' + ip_addr + '" data-placement="right" data-trigger="hover"><circle class="classPC classNone" id="c1_' + id + '"  fill="transparent" stroke="#f79545" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12" onclick="pcclickjs(' + id + ')"></circle><circle class="classPC classNone" id="c2_' + id + '"   fill="transparent" stroke="#f79545" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10" onclick="pcclickjs(' + id + ')"></circle><circle  class="classPC classNone" id="c3_' + id + '"   cx="' + x + '" cy="' + y + '" r="8" fill="#f79545" onclick="pcclickjs(' + id + ')"></circle></a>';
                            }
                            index++;
                            } else if (data[i]['type'] == 'wifi') {
                            totalWifiFloor = totalWifiFloor + 1;
                            var x = data[i]['x_axis'];
                            var y = data[i]['y_axis'];
                            var id = data[i]['id'];
                            var id_no = (data[i]['zm_id'] != null?data[i]['zm_id']:"");
                            var ip_addr = (data[i]['link'] != null ? data[i]['link'] : '');
                            var namedevice = (data[i]['name'] != null ? data[i]['name'] : '');
                            if (data[i]['isalive'] == 0)
                            {
                            totalDeadWifiFloor = totalDeadWifiFloor + 1;
                            div.innerHTML += '<a data-toggle="popover" id="pop_' + id + '"  class="popover-icon" data-container="body" title="' + namedevice + '" data-content="' + id_no + '<br>' + ip_addr + '" data-placement="right" data-trigger="hover"><circle class="classWifi classNone" id="c1_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle class="classWifi classNone" id="c2_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle class="classWifi classNone"  id="c3_' + id + '"  cx="' + x + '" cy="' + y + '" r="8" fill="#04d9ff"  onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="' + blinkAnimated + '" /><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="' + blinkAnimated + '" /></circle></a>';
                            } else
                                    div.innerHTML += '<a data-toggle="popover" id="pop_' + id + '"  class="popover-icon" data-container="body" title="' + namedevice + '" data-content="' + id_no + '<br>' + ip_addr + '" data-placement="right" data-trigger="hover"><circle class="classWifi classNone" id="c1_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle class="classWifi classNone" id="c2_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle class="classWifi classNone"  id="c3_' + id + '"  cx="' + x + '" cy="' + y + '" r="8" fill="#04d9ff"  onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle></a>';
                            index++;
                            }
                            showDevice();
                            }
                            }
                            document.getElementById("offwifi").innerHTML = totalDeadWifiFloor + " Device";
                            document.getElementById("offpc").innerHTML = totalDeadPCFloor + " Device";
                            if (infoDeviceMati.length != 0) {
                            var info = "";
                            for (var i = 0; i < infoDeviceMati.length; i++) {
                            if (infoDeviceMati[i]['name'] == null)
                                    namemodal = "";
                            else
                                    namemodal = infoDeviceMati[i]['name'];
                            if (infoDeviceMati[i]['ip'] == null)
                                    ipmodal = "";
                            else
                                    ipmodal = infoDeviceMati[i]['ip'];
                            if ($('#dropDownDevice').val() == 'classWifi') {
                            if (infoDeviceMati[i]['type'] == 'wifi') {
                            if (info != '')
                                    info += ' <br/>';
                            info += namemodal + "|" + ipmodal;
                            }
                            } else if ($('#dropDownDevice').val() == 'classPC') {
                            if (infoDeviceMati[i]['type'] == 'pc') {
                            if (info != '')
                                    info += ' <br/>';
                            info += namemodal + "|" + ipmodal;
                            }
                            } else {
                            if (info != '')
                                    info += ' <br/>';
                            info += namemodal + "|" + ipmodal;
                            }
                            }
                            $("#error").html(info);
                            $('#myModal').modal("show");

                            }
                        }
                        }
                }).then(
                    function() {
                      console.log('finished ALL OK')
                    setTimeout(refreshData, 30000);
                    })
                }else if (checkloop=2)
                   showHeatMap(floorvalue,pos);
        }
        function changemaps(a) {
        var idfloor = '';
        var totalWifiFloor = 0;
        var totalPCFloor = 0;
        var totalDeadWifiFloor = 0;
        var totalDeadPCFloor = 0;
        var displayAwal = 0;
        var div = document.getElementById('maps');
        
        if (checkloop == 1) {
            $.ajax({
                type: 'GET',
                url: window.location.origin + "/changefloor/" + a,
                beforeSend: function () {
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    var blinkAnimated = 1;
                    
                    document.getElementById('mps').setAttribute('href', '../' + data[0]['maps_img']);
                    document.getElementById('floorname_id').innerHTML = `${data[0]['sitename']} Floor ${data[0]['name']}`;
                    idfloor = data[0]['id'].toString();
                    
                    if (arrId.length != 0) displayAwal = 1;
                    arrDeadId = {};
                    
                    $.ajax({
                        type: 'GET',
                        url: window.location.origin + "/floorUser/" + idfloor,
                        beforeSend: function () {
                            div.innerHTML = '';
                        },
                        success: function (response) {
                            var data = JSON.parse(response);
                            
                            if (data.length != 0) {
                                data.forEach(function(item, i) {
                                    if (displayAwal == 0) arrId.push(item['id']);
                                    
                                    if (item['isalive'] == 0) arrDeadIdTotal.push(item['id']);
                                    
                                    if (item['type'] == 'pc') {
                                        totalPCFloor++;
                                        var { x_axis: x, y_axis: y, id, zm_id: id_no = "", link: ip_addr = '', name: namedevice = '' } = item;
                                        if (item['isalive'] == 0) {
                                            totalDeadPCFloor++;
                                            div.innerHTML += createCircleElement(id, namedevice, id_no, ip_addr, x, y, '#f79545', blinkAnimated, 'pcclickjs');
                                        } else {
                                            div.innerHTML += createCircleElement(id, namedevice, id_no, ip_addr, x, y, '#f79545', null, 'pcclickjs');
                                        }
                                    } else if (item['type'] == 'wifi') {
                                        totalWifiFloor++;
                                        var { x_axis: x, y_axis: y, id, zm_id: id_no = "", link: ip_addr = '', name: namedevice = '' } = item;
                                        if (item['isalive'] == 0) {
                                            totalDeadWifiFloor++;
                                            div.innerHTML += createCircleElement(id, namedevice, id_no, ip_addr, x, y, '#04d9ff', blinkAnimated, 'wificlickjs');
                                        } else {
                                            div.innerHTML += createCircleElement(id, namedevice, id_no, ip_addr, x, y, '#04d9ff', null, 'wificlickjs');
                                        }
                                    }
                                });
                            }
                            
                            updateDeviceCounts(totalWifiFloor, totalPCFloor, totalDeadWifiFloor, totalDeadPCFloor);
                            showDevice();
                        }
                    });
                }
            });
        } else if (checkloop == 2) {
            $.ajax({
                type: 'GET',
                url: window.location.origin + "/changefloor/" + a,
                beforeSend: function () { 
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    document.getElementById('mps').setAttribute('href', '../' + data[0]['maps_img']);
                    document.getElementById('floorname_id').innerHTML = `${data[0]['sitename']} Floor ${data[0]['name']}`;
                    showHeatMap(a, '0');
                }
            });
        }
    }

    function createCircleElement(id, namedevice, id_no, ip_addr, x, y, color, blinkAnimated, clickFunction) {
        var animatedPart = blinkAnimated ? `<animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="${blinkAnimated}" />` : '';
        return `
            <a data-toggle="popover" id="pop_${id}" class="popover-icon" data-container="body" title="${namedevice}" data-content="${id_no}<br>${ip_addr}" data-placement="right" data-trigger="hover">
                <circle class="classPC classNone" id="c1_${id}" fill="transparent" stroke="${color}" stroke-width="0.5" cx="${x}" cy="${y}" r="12" onclick="${clickFunction}(${id})">${animatedPart}</circle>
                <circle class="classPC classNone" id="c2_${id}" fill="transparent" stroke="${color}" stroke-width="0.5" cx="${x}" cy="${y}" r="10" onclick="${clickFunction}(${id})">${animatedPart}</circle>
                <circle class="classPC classNone" id="c3_${id}" cx="${x}" cy="${y}" r="8" fill="${color}" onclick="${clickFunction}(${id})">${animatedPart}</circle>
            </a>`;
    }

    function updateDeviceCounts(totalWifiFloor, totalPCFloor, totalDeadWifiFloor, totalDeadPCFloor) {
        document.getElementById("floorwifi").innerHTML = `${totalWifiFloor} Device`;
        document.getElementById("floorpc").innerHTML = `${totalPCFloor} Device`;
        document.getElementById("offwifi").innerHTML = `${totalDeadWifiFloor} Device`;
        document.getElementById("offpc").innerHTML = `${totalDeadPCFloor} Device`;
    }


    
        function showDeviceData(){
            var classnya = $('#dropDownDevice').val();
               if(classnya!='classWifi')checkloop=1; else checkloop=2;
                   $.ajax({
            type: 'GET',
                    url: window.location.origin + "/selectDeviceType/" + classnya,
                    
                     success: function (response) {
                         refreshData();
                     }
                 });
 
            
        }
        function showDevice() {
            var classnya = $('#dropDownDevice').val();
            console.log(classnya);
            
            if(classnya!='classWifi'){
                $('.classNone').hide();
                $('.' + classnya).show();
            }
        }
        function loadAllDataWifi(id){
            $.ajax({
                            type: 'GET',
                            url: window.location.origin + "/getAllWifiDevices/" + id,
                            success : function (data) {
                                var response = JSON.parse(data);
                                console.log(response[0]['download']);
                                document.getElementById("wifidownload").innerHTML =response[0]['download'];
                                document.getElementById("wifiupload").innerHTML =response[0]['upload'];
                            }
                        })
        }
        function wificlickjs(id, pos) {
            console.log("ddadas");
            checkloop = 0;    
            if($("#dropDownDevice").val()=='classWifi') checkloop = 2;    
            console.log('finished ALL1z OK='+checkloop);
            $(".popover").hide();
            $.ajax({
                    type: 'GET',
                    url: window.location.origin + "/wifidatadetail/" + id,
                    beforeSend: function () {
                    $("#pop_" + id).popover('hide');
                    },
                    success : function (data) {
                        var response = JSON.parse(data);
                        document.getElementById("point_id").innerHTML = response[0]['Name'].toString();
                        var div = document.getElementById('wifistatus');
                        div.value = '1';
                        xpos="20";
                        xposname="40";
                        document.getElementById('wifi').setAttribute('href', "../asset/wifi2.png");
                        valCount=response[0]['Count'].toString();
                        xpos=45-5*valCount.length;
                        valName=response[0]['Name'];
                        if(valName.length>11)
                            xposname=40-((valName.length-11)*2);
                    
                        <!--<text x="30%" y="80%" font-family="Poppins" font-size="9px" fill="' + colortext + '">' +<?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text>\n\
                        document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="'+xpos+'%" y="50%" font-family="Poppins" font-size="55px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                                            <text x="'+xposname+'%" y="60%" font-family="Poppins" font-size="10px" fill="' + colortext + '">' + response[0]['Name'] + '</text>\n\
                                                                            <text x="40%" y="83%" font-family="Poppins" font-size="10px" fill="' + colortext + '">' + (response[0]['Ip']==null?'':response[0]['Ip']) + '</text>\n\
                                                                            <text x="10%" y="80%" font-family="Poppins" font-size="12px" fill="' + colortext + '" id="wifidownload">' + response[0]['WifiDownload']  + '</text>\n\\n\
                                                                            <text x="65%" y="80%" font-family="Poppins" font-size="12px" fill="' + colortext + '" id="wifiupload">' + response[0]['WifiUpload']  + '</text>\n\
                                                                            <text x="7%" y="90%" font-family="Poppins" font-size="9px" fill="' + colortext + '" font-height="bold">Mbps Download</text>\n\
                                                                            <text x="62%" y="90%" font-family="Poppins" font-size="9px" fill="' + colortext + '" font-height="bold">Mbps Upload</text>';
                        if (response[0]['Count'] != 0 || response[0]['Count'] != '0') 
                        {
                            counter("wificount1", 0, parseInt(response[0]['Count']), 1);
                        } else  {
                            document.getElementById('wificount1').innerHTML = 0;
                        }
                        var nameuri=response[0]['Name'];
                         nameuri = nameuri.replace(/\//g, ';');
                         console.log(nameuri);
                         $.ajax({
                            type: 'GET',
                            url: window.location.origin + "/getWifiDevices/" + id+"/"+nameuri,
                            success : function (data) {
                                var response = JSON.parse(data);
                                console.log(response[0]['download']);
                                document.getElementById("wifidownload").innerHTML =response[0]['download'];
                                document.getElementById("wifiupload").innerHTML =response[0]['upload'];
                            }
                        }).then(
                            function() {
                                if(checkloop==0){
                                    var classnya = $('#dropDownDevice').val();
                                    if(classnya!='classWifi')checkloop=1; else checkloop=2;
                                    console.log('finished ALL1 OK='+checkloop);
                                    setTimeout(refreshData, 30000);
                                }
                                
                               //}
                            });
                        }    
            });         
            ;
        }           
        function pcclickjs(id) {
            $(".popover").hide();
            $.ajax({
            type: 'GET',
                    url: window.location.origin + "/pcclick/" + id,
                    beforeSend: function () {
                    },
                    success: function (response) {
    // Log the response
    document.getElementById("point_id").innerHTML = response[0]['Name'].toString();
    var count = response[0]['Count'].toString();
    xpospc = 45 - 5 * count.length;
    var div = document.getElementById('pcstatus');
    div.value = '1';
    document.getElementById('pc').setAttribute('href', "../asset/pc2.png");
    document.getElementById("pcrect").innerHTML = '<text x="14%" y="25%" font-family="Poppins" font-size="14px" fill="' + colortext + '">' + <?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text>\n\
                                                   <text id="pccount" x="10%" y="58%" font-family="Poppins" font-size="40px" fill="' + colortext + '" font-weight="bold"></text><text x="10%" y="75%" font-family="Poppins" font-size="10px" fill="' + colortext + '">' + response[0]['Name'] + '</text><text x="39%" y="85%" font-family="Poppins" font-size="15px" fill="' + colortext + '">' + currentHours + ' : ' + currentMinutes + '</text>';
    if (count < 500) {
        counter("pccount", 0, count, 1);
    } else {
        counter("pccount", parseInt(count - 500), count, 1);
    }
}
            });
        }

        function changemapsbyfloor(id){
         window.location = window.location.origin + "/indexbyfloor/" + id;
        }
                        
        function menus() {
            var firstmenu = parseInt(menu * 4) - 3;
            var lastmenu = parseInt(menu * 4);
            var innerhtml = '';
            innerhtml = '<text x="50%" y="85%" font-family="Poppins" font-size="10px" fill="' + colortext + '" onclick="prevs();">Previous</text><text x="80%" y="85%" font-family="Poppins" font-size="10px" fill="' + colortext + '" onclick="nexts();">Next</text>';
            for (var i = 0; i < floor.length; i++) {
                if (parseInt(floor[i]['sequence_number']) >= firstmenu && parseInt(floor[i]['sequence_number']) <= lastmenu) {
                    if (parseInt(i % 4) == 0) {
                    innerhtml = innerhtml + '<text onclick="changemapsbyfloor(' + floor[i]['id'] + ');" x="10%" y="40%" font-family="Poppins" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
                    } else if (parseInt(i % 4) == 1) {
                    innerhtml = innerhtml + '<text onclick="changemapsbyfloor(' + floor[i]['id'] + ');" x="10%" y="50%" font-family="Poppins" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
                    } else if (parseInt(i % 4) == 2) {
                    innerhtml = innerhtml + '<text onclick="changemapsbyfloor(' + floor[i]['id'] + ');" x="10%" y="60%" font-family="Poppins" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
                    } else if (parseInt(i % 4) == 3) {
                    innerhtml = innerhtml + '<text onclick="changemapsbyfloor(' + floor[i]['id'] + ');" x="10%" y="70%" font-family="Poppins" font-size="12px" fill="' + colortext + '">&#9654; ' + floor[i]['name'] + '</text>';
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

                document.getElementById("srect").innerHTML = innerhtml;
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
                
 function wificlick() {
            var div = document.getElementById('wifistatus');
            div.value = '0';
            var wifiDownload = <?php echo isset($wifiDownload) ? json_encode($wifiDownload) : 0; ?>;
            var wifiUpload = <?php echo isset($wifiUpload) ? json_encode($wifiUpload) : 0; ?>;
            document.getElementById('wifi').setAttribute('href', "../asset/wifi1.png");
            document.getElementById("wifirect").innerHTML = '<text id="wificount1" x="20%" y="50%" font-family="Poppins" font-size="55px" fill="' + colortext + '" font-weight="bold"></text>\n\
                                                            <text x="18%" y="60%" font-family="Poppins" font-size="14px" fill="' + colortext + '">Connected Device</text>\n\
                                                            <text x="10%" y="82%" font-family="Poppins" font-size="12px" fill="' + colortext + '" id="wifidownload">' + wifiDownload + '</text>\n\\n\
                                                            <text x="65%" y="82%" font-family="Poppins" font-size="12px" fill="' + colortext + '" id="wifiupload">' + wifiUpload + '</text>\n\
                                                            <text x="7%" y="90%" font-family="Poppins" font-size="9px" fill="' + colortext + '" font-height="bold">Mbps Download</text>\n\
                                                           <text x="62%" y="90%" font-family="Poppins" font-size="9px" fill="' + colortext + '" font-height="bold">Mbps Upload</text>';
            var unifi = <?php echo isset($unifi) ? json_encode($unifi) : 0; ?>;
            if (unifi != 0 || unifi != '0') {
            counter("wificount1", 0, parseInt(unifi), 1);
            } else {
            document.getElementById("wificount1").value = 0;
            }
            document.getElementById("point_id").innerHTML = '';
            document.getElementById('floorId').value = FloorID;

        loadAllDataWifi(FloorID);
                    }

                    function pcclick() {
                    var div = document.getElementById('pcstatus');
            var pcounting = <?php echo isset($PeopleCounting) ? json_encode($PeopleCounting) : 0; ?>;
            div.value = '0';
            document.getElementById('pc').setAttribute('href', "../asset/pc1.png");
            document.getElementById("pcrect").innerHTML = '<text x="14%" y="25%" font-family="Poppins" font-size="14px" fill="' + colortext + '">' +<?php echo isset($compname) ? json_encode($compname) : 0; ?> + '</text><text id="pccount" x="10%" y="58%" font-family="Poppins" font-size="40px" fill="' + colortext + '" font-weight="bold"></text><text x="33%" y="75%" font-family="Poppins" font-size="10px" fill="' + colortext + '">People Counting</text><text x="39%" y="85%" font-family="Poppins" font-size="15px" fill="' + colortext + '">' + currentHours + ' : ' + currentMinutes + '</text>';
            document.getElementById("point_id").innerHTML = '';
            counter("pccount", parseInt(pcounting - 500), pcounting, 1);
        }
                
                
                
        function counter(id, start, end, duration) {
            if (end == 0) {
                document.getElementById(id).innerHTML = 0;
            } else {
                let obj = document.getElementById(id),
                current = start,
                range = end - start,
                increment = end > start ? 1 : - 1,
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

            var totalWifiFloor = 0;
            var totalPCFloor = 0;
            var totalDeadWifiFloor = 0;
            var totalDeadPCFloor = 0;
            var div = document.getElementById('maps');
            $.ajax({
            type: 'GET',
                    url: window.location.origin + "/heatdata/" + a,
                    beforeSend: function () {$("#pop_" + iddevice).popover('hide');
                    },
                    success: function (data) {
                        if(checkloop==2){
                    div.innerHTML = '';
                    //        div2.innerHTML = '';
                    if (data.length != 0) {
                    document.getElementById('mps').setAttribute('href', '../' + data[0]['maps_img']);
                    for (var i = 0; i < data.length; i++) {
                   if (data[i]['tipe'] == 'pc') {
                        totalPCFloor = totalPCFloor + 1;
                                if (data[i]['isalive'] == 0)
                                {
                                totalDeadPCFloor = totalDeadPCFloor + 1;
                                }
                    index++;
                    } else if (data[i]['tipe'] == 'wifi') {
                    // console.log(totalWifiFloor);
                    var id = data[i]['id'];
                    var x = data[i]['x_axis'];
                    var y = data[i]['y_axis'];
                    var ip_addr = (data[i]['link'] != null ? data[i]['link'] : '');
                    var id_no = (data[i]['zm_id'] != null?data[i]['zm_id']:"");
                    var ip_addr = (data[i]['link'] != null ? data[i]['link'] : '');
                    var namedevice = (data[i]['name'] != null ? data[i]['name'] : '');
                    var count = parseInt(data[i]['count']);
                    if (count > 0 && count <= 7) {
                    var color = 'green';
                    } else if (count > 7 && count <= 15) {
                    var color = 'yellow';
                    } else if (count > 15) {
                    var color = 'red';
                    } else {
                    var color = 'green';
                    }
                    let str = index.toString();
                    totalWifiFloor = totalWifiFloor + 1;
                    if (data[i]['isalive'] == 0)
                    {
                    totalDeadWifiFloor = totalDeadWifiFloor + 1;
            
                            div.innerHTML += '<a data-toggle="popover" id="pop_' + id + '"  class="popover-icon" data-container="body" title="' + namedevice + '" data-content="' + id_no + '<br>' + ip_addr + '" data-placement="right" data-trigger="hover"><circle class="classWifi classNone" id="c1_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle class="classWifi classNone" id="c2_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle class="classWifi classNone"  id="c3_' + id + '"  cx="' + x + '" cy="' + y + '" r="8" fill="#04d9ff"  onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle style="filter: blur(50px);" id="c1' + index + '" cx="' + x + '" cy="' + y + '" r="80" fill="' + color + '" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle></a>';
                    } else
                            div.innerHTML += '<a data-toggle="popover" id="pop_' + id + '"  class="popover-icon" data-container="body" title="' + namedevice + '" data-content="' + id_no + '<br>' + ip_addr + '" data-placement="right" data-trigger="hover"><circle class="classWifi classNone" id="c1_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle class="classWifi classNone" id="c2_' + id + '"  fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle class="classWifi classNone"  id="c3_' + id + '"  cx="' + x + '" cy="' + y + '" r="8" fill="#04d9ff"  onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle><circle style="filter: blur(50px);" id="c1' + index + '" cx="' + x + '" cy="' + y + '" r="80" fill="' + color + '" onclick="wificlickjs(\'' + id + '\',\'' + index + '\');"></circle></a>';
                    index++;

                    index++;
                    }

                    }
                    }
                    $("#pop_" + iddevice).popover('show');
                                document.getElementById("floorwifi").innerHTML = totalWifiFloor + " Device";
                                document.getElementById("floorpc").innerHTML = totalPCFloor + " Device";
                                document.getElementById("offwifi").innerHTML = totalDeadWifiFloor + " Device";
                                document.getElementById("offpc").innerHTML = totalDeadPCFloor + " Device";
                    }
                    }
            }).then(
                    function() {
                        if(checkloop==2){
                            //checkloop=1
                            var classnya = $('#dropDownDevice').val();
                            if(classnya!='classWifi')checkloop=1; else checkloop=2;
                            console.log('finished ALL2 OK')
                            setTimeout(refreshData, 30000);
                                                        }
                }
                );;
        }

                 
                       
        function setIntervalData(){
            setTimeout(refreshData, 30000);
        }
    </script>

    <script>
   $(document).ajaxStop(function () {
        if (checkloop == 1){
        }
    });
    $(document).on("mouseover", ".popover-icon", function (e) {
        idnya = this.id;
        $('#' + idnya).popover({html: true});
        $('#' + idnya).popover('show');
    });
    $(document).on("mouseout", ".popover-icon", function (e) {
        idnya = this.id;
        $('#' + idnya).popover({html: true});
        $('#' + idnya).popover('hide');
    });
    jQuery.fn.extend({
        myShow: function () {
        return this.attr('aria-hidden', 'false').show()
        },
        myHide: function () {
        return this.attr('aria-hidden', 'true').hide()
        }
    });


</script>
        <!--
        function removePopOver(id) {
              id = "#" + id;
              $(id).popover('dispose');
        }-->
    </html><!-- comment -->
