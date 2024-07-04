<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Simple CMS" />
        <title>Mall Dashboard - Home</title>
        <link href = {{ asset("css/bootstrap.css") }} rel="stylesheet" />
        <link href = {{ asset("css/sticky-footer-navbar.css") }} rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('css/simplePagination.css') }}"/>
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
            .fill {
                height: 60%;
            }
            .btn{
                background-color: transparent;
                color: white;
            }
            div {
                row-gap: 2 cm;
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
            .borderdiv {
                border-top:1px solid purple;
                border-left:1px solid purple;
                border-right:1px solid purple;
                
            }
             .bordertext {
                border-top:1px solid purple; 
                
            }
            .borderrighttext {
               border-right:1px solid purple; ; 
                
            }
            .borderbottom {
                border-bottom:1px solid purple; 
                
            }
            .namalantai{
                background-color: purple;
                margin-top: 2rem;
            }
        </style>
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('js/jquery.simplePagination.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    </head>
    <body>
        <div class="container-fluid text-center" style="padding: 0%;">
            {{-- header --}}
            <div class="row mt-2 mb-2">
                <div class="col-8 text-left text-uppercase header mt-2" style="margin-left: 2rem">
                    <span id="floorname_id" style="font-size:30px;color:whitesmoke;font-weight:bold;"></span>
                </div>
                <div class="col-2 text-right" style="margin-top: 1rem; padding:0%; margin-left:4rem;"  >
                    <select id="dropdownmall" onchange="changeLayout()" style="background-color: transparent; border-color:transparent; color:white">
                        @if ($Data->count() > 0)
                        @foreach ($Data as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->sitename }}
                        </option>
                        @endForeach
                        @else
                        No Record Found
                        @endif
                    </select>
                    <select id="dropdowndisplay" onchange="changeLayout()" style="background-color: transparent; border-color:transparent; color:white">
                        <option value="33">3x3</option>
                        <option value="32">3x2</option>
                    </select>
                </div>
                <div class="col-1 " style="margin-top: 0.6rem;padding:0%;"> 
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn regular">Logout</button>
                    </form>
                </div>
            </div>
            {{-- Maps / Floor  --}}
            <div class="row class33 classLayout" style="margin-top:2rem">
                <div class="col-3" id="class33_1_1" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:7rem;margin-right:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"
                        xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                        <image id="mps33_1_1" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png"href=""></image>
                    <g onclick="picClick('floorIdPic1');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                        </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic1"/>
                    <g id="maps33_1_1" class="detailMaps"></g>
                    </svg>
                        <div id="mapstext33_1_1" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>
            
                <div class="col-3" id="class33_1_2" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet"nstyle="margin-top: 2rem;">
                    <image id="mps33_1_2" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png" href="" "></image>
                     <g onclick="picClick('floorIdPic2');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic2"/>
                    <g id="maps33_1_2" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_1_2" class="detailMaps namalantai" style="color:whitesmoke; padding:0%"></div>
                </div>

                <div class="col-3" id="class33_1_3" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000" xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps33_1_3" width="1903" class="myMapsImg" height="1000" xlink:href="peta/b2.png" href=""></image>
                    <g onclick="picClick('floorIdPic3');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic3"/>
                    <g id="maps33_1_3" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_1_3" class="detailMaps namalantai" style="color:whitesmoke; padding:0%"></div>
                </div>

            </div>
            <div class="row class33 classLayout">
                <div class="col-3" id="class33_2_1" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:7rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps33_2_1" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png" href=""></image>
                    <g onclick="picClick('floorIdPic4');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic4"/>
                    <g id="maps33_2_1" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_2_1" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>

                <div class="col-3" id="class33_2_2" style="padding-top:0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps33_2_2" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png" href=""></image>
                    <g onclick="picClick('floorIdPic5');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic5"/>
                    <g id="maps33_2_2" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_2_2" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>

                <div class="col-3" id="class33_2_3" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000" xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps33_2_3" width="1903" height="1000" xlink:href="peta/b2.png" class="myMapsImg" href=""></image>
                    <g onclick="picClick('floorIdPic6');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                        </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic6"/>
                    <g id="maps33_2_3" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_2_3" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>
            </div>
            <div class="row class33 classLayout">
                <div class="col-3" id="class33_3_1" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:7rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps33_3_1" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png" href=""></image>
                    <g onclick="picClick('floorIdPic7');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic7"/>
                    <g id="maps33_3_1" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_3_1" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>
                
                <div class="col-3" id="class33_3_2" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000" xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps33_3_2" width="1903" height="1000" xlink:href="peta/b2.png" href="" class="myMapsImg"></image>
                     <g onclick="picClick('floorIdPic8');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic8"/>
                    <g id="maps33_3_2" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_3_2" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>

                <div class="col-3" id="class33_3_3" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000" xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps33_3_3" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png"href=""></image>
                    <g onclick="picClick('floorIdPic9');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic9"/>
                    <g id="maps33_3_3" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext33_3_3" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>   
            </div>

            <div class="row mt-2 class32 classLayout" style="display:none">
                 <div class="col-3" id="class32_1_1" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:7rem;margin-right:2rem;margin-top:2rem;" >
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps32_1_1" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png" href=""></image>
                    <g onclick="picClick('floorIdPic2_1');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic2_1"/>
                    <g id="maps32_1_1" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext32_1_1" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>

                <div class="col-3" id="class32_1_2" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps32_1_2" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png"href=""></image>
                    <g onclick="picClick('floorIdPic2_2');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic2_2"/>
                    <g id="maps32_1_2" class="detailMaps"> </g>
                    </svg>
                    <div id="mapstext32_1_2" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>

                <div class="col-3" id="class32_1_3" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;" >
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps32_1_3" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png"href=""></image>
                    <g onclick="picClick('floorIdPic2_3');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic2_3"/>
                    <g id="maps32_1_3" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext32_1_3" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>
            </div>

            <div class="row   class32 classLayout" style="display:none">
            <div class="col-3" id="class32_2_1" style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:7rem;margin-right:2rem;margin-top:2rem;" >
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps32_2_1" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png"href=""></image>
                    <g onclick="picClick('floorIdPic2_4');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                        </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic2_4"/>
                    <g id="maps32_2_1" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext32_2_1" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>

                <div class="col-3" id="class32_2_2"style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;" >
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps32_2_2" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png" href=""></image>
                    <g onclick="picClick('floorIdPic2_5');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic2_5"/>
                    <g id="maps32_2_2" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext32_2_2" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>

                <div class="col-3" id="class32_2_3"  style="padding-top: 0.5%;padding-left:0%; padding-right:0%;margin-left:2rem;margin-right:2rem;margin-top:2rem;">
                    <svg version="1.1" id="Layer_1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1903 1000"xml:space="preserve"  preserveAspectRatio="xMaxYMin meet" >
                    <image id="mps32_2_3" class="myMapsImg" width="1903" height="1000" xlink:href="peta/b2.png"href=""></image>
                    <g onclick="picClick('floorIdPic2_6');">
                        <rect class="btn" style="background-color: yellow;fill-opacity:0;" x="0" y="0" fill="yellow" width="1903" height="1000"/>
                    </g>
                        <input type="hidden" name="floorIdPic" id="floorIdPic2_6"/>
                    <g id="maps32_2_3" class="detailMaps"></g>
                    </svg>
                    <div id="mapstext32_2_3" class="detailMaps namalantai" style="color:whitesmoke;"></div>
                </div>
            </div>

            <div class="row" style="display: flex; justify-content: center; margin-top:2rem;">
                <div id="pagination-container"></div>
            </div>

            <footer style="color: white; background-color: #11142C; margin-top: 2%; padding: 1px;">
                    <p style="text-align: center; padding-top:1%">&copy; Mall Dashboard 2024 | Bedria Mashyanda Maail - 2440027303</p>
            </footer>
            
        </div>
        </div>
    </body>
    <script>
        var numItems = 0;
        var perPage = 4;
        $(document).ready(function () {
            $("#dropdownmall").val($("#dropdownmall option:first").val());
            a = $('#dropdownmall').val();
            console.log($("#dropdownmall option:selected").text());
            $("#floorname_id").text($("#dropdownmall option:selected").text());
            $.ajax({
                type: 'GET',
                url: window.location.origin + "/getMap/" + a,
                beforeSend: function () {
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    var test = "";
                    var classval = $("#dropdowndisplay").val();
                    var rowdiv = 1;
                    var coldiv = 1;
                    var picNum=1;
                    var idfloormaps="";
                    if (data.length != 0) {
                        numItems = data.length;
                        for (var i = 0; i < data.length; i++)
                        {
                            if (i % 3 == 0 && i != 0) {
                                coldiv = 1;
                                rowdiv++;
                            } else if (i != 0) {
                                coldiv++;
                            }
                            if (classval == '33' && i < 9) {
                                perPage = 9;
                              console.log("coldiv=" + coldiv);
                                console.log(data[i]['id']);
                                 $('#mps' + classval + "_" + rowdiv + "_" + coldiv).myShow();
                                  $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderdiv');
                                    $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('bordertext');
                                    if(coldiv==3)
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderrighttext');
                                    if(rowdiv==3){
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');  
                                        $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');
                                  }  
                                 document.getElementById('mps' + classval + "_" + rowdiv + "_" + coldiv).setAttribute('href', '' + data[i]['maps_img']);
                                document.getElementById('mapstext' + classval + "_" + rowdiv + "_" + coldiv).innerHTML =  data[i]["name"];
                                idfloormaps='maps' + classval + "_" + rowdiv + "_" + coldiv;
                                document.getElementById('floorIdPic'+picNum).value=data[i]['id'];
                              
                            }else if (classval == '32' && i < 6) {
                                perPage = 6;
                                 $('#mps' + classval + "_" + rowdiv + "_" + coldiv).myShow();
                                  $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderdiv');
                                  $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('bordertext');
                                  if(coldiv==3)
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderrighttext');
                                  if(rowdiv==2){
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');  
                                        $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');
                                  }       
                                document.getElementById('mps' + classval + "_" + rowdiv + "_" + coldiv).setAttribute('href', '' + data[i]['maps_img']);
                                document.getElementById('mapstext' + classval + "_" + rowdiv + "_" + coldiv).innerHTML =  data[i]["name"];
                                idfloormaps='maps' + classval + "_" + rowdiv + "_" + coldiv;
                                document.getElementById('floorIdPic2_'+picNum).value=data[i]['id'];
                            }
                             changemaps(idfloormaps, data[i]['id']);
                             picNum++;
                        }
                    }
                    $('#pagination-container').pagination({
                        items: numItems,
                        itemsOnPage: perPage,
                        prevText: "&laquo;",
                        nextText: "&raquo;",
                        onPageClick: function (pageNumber) {
                            showPages(pageNumber, perPage);
                        }
                    });
                }
            });
        });
        var index = 0;
        var type = 'pc';
        function changemaps(id,idfloor) {
            var div = document.getElementById(id);
            console.log(id);
                    $.ajax({
                        type: 'GET',
                        url: window.location.origin + "/floor/" + idfloor,
                        beforeSend: function () {
                            div.innerHTML = '';
                        },
                        success: function (response) {
                            div.innerHTML = '';
                            var data = JSON.parse(response);
                          
                            if (data.length != 0) {
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i]['type'] == 'pc') {
                                        var x = data[i]['x_axis'];
                                        var y = data[i]['y_axis'];
                                        var id = data[i]['id'];
                                        var ip_addr = (data[i]['link']!=null?data[i]['link']:'');
                                        var namedevice = (data[i]['name']!=null?data[i]['name']:'');
                                        div.innerHTML += '<a data-toggle="popover" id="pop' + index + '"  class="popover-icon" data-container="body" title="Device Name" data-content="'+namedevice+'<br>'+ip_addr+'" data-placement="right" data-trigger="hover"><circle id="c1' + index + '" fill="transparent" stroke="#f79545" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle id="c2' + index + '" fill="transparent" stroke="#f79545" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle  id="c3' + index + '" cx="' + x + '" cy="' + y + '" r="8" fill="#f79545" onclick="pcclickjs(' + id + ')"</circle></a>';
                                        index++;
                                    } else if (data[i]['type'] == 'wifi') {
                                        var x = data[i]['x_axis'];
                                        var y = data[i]['y_axis'];
                                        var id = data[i]['id'];
                                        var ip_addr = (data[i]['link']!=null?data[i]['link']:'');
                                        var namedevice = (data[i]['name']!=null?data[i]['name']:'');
                                        div.innerHTML += '<a data-toggle="popover" id="pop' + index + '"  class="popover-icon" data-container="body" title="Device Name" data-content="'+namedevice+'<br>'+ip_addr+'" data-placement="right" data-trigger="hover"><circle id="c1' + index + '" fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="12"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="1" /></circle><circle id="c2' + index + '" fill="transparent" stroke="#04d9ff" stroke-width="0.5" cx="' + x + '" cy="' + y + '" r="10"><animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0" /></circle><circle  id="c3' + index + '" cx="' + x + '" cy="' + y + '" r="8" fill="#04d9ff"  onclick="wificlickjs(\'' + id + '\',\''+index+'\');"></circle></a>';
                                        index++;
                                    }
                                }
                            }
                        }
                    });
        }
        function picClick(id){
        console.log($("#"+id).val());
        window.location = window.location.origin + "/indexbyfloor/" + $("#"+id).val();
        }
        function changeLayout(){
            var valLayout = $("#dropdowndisplay").val();
           console.log(valLayout);
            $(".classLayout").hide();
            $(".class" + valLayout).show();
            a = $('#dropdownmall').val();
             console.log($("#dropdownmall option:selected").text());
              $("#floorname_id").text($("#dropdownmall option:selected").text());
            $(".detailMaps").text("");
            $.ajax({
                type: 'GET',
                url: window.location.origin + "/getMap/" + a,
                beforeSend: function () {
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    var test = "";
                    var classval = $("#dropdowndisplay").val();
                    var rowdiv = 1;
                    var coldiv = 1;
                     var picNum=1;
                    if (data.length != 0) {
                        numItems = data.length;
                        for (var i = 0; i < data.length; i++)
                        {
                            if (i % 3 == 0 && i != 0) {
                                coldiv = 1;
                                rowdiv++;
                            } else if (i != 0) {
                                coldiv++;
                            }
                            if (classval == '33' && i < 9) {
                                perPage = 9;
                                console.log("coldivx=" + coldiv);
                                console.log(rowdiv)
                                console.log(data[i]);
                                 $('#mps' + classval + "_" + rowdiv + "_" + coldiv).myShow();  $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderdiv');
                                    $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('bordertext');
                                    if(coldiv==3)
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderrighttext');
                                    if(rowdiv==3){
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');  
                                        $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');
                                  }  
                                 
                                document.getElementById('mps' + classval + "_" + rowdiv + "_" + coldiv).setAttribute('href', '' + data[i]['maps_img']);
                                document.getElementById('mapstext' + classval + "_" + rowdiv + "_" + coldiv).innerHTML =  data[i]["name"];
                                idfloormaps='maps' + classval + "_" + rowdiv + "_" + coldiv;
                                document.getElementById('floorIdPic'+picNum).value=data[i]['id'];
                              
                            }else if (classval == '32' && i < 6) {
                                perPage = 6;
                                 $('#mps' + classval + "_" + rowdiv + "_" + coldiv).myShow();
                                   $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderdiv');
                                    $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('bordertext');
                                    if(coldiv==3)
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderrighttext');
                                    if(rowdiv==2){
                                        $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');  
                                        $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');
                                  }  
                                document.getElementById('mps' + classval + "_" + rowdiv + "_" + coldiv).setAttribute('href', '' + data[i]['maps_img']);
                                console.log(classval);
                                console.log(rowdiv);
                                console.log(coldiv);
                                console.log('mapstext' + classval + "_" + rowdiv + "_" + coldiv);
                                document.getElementById('mapstext' + classval + "_" + rowdiv + "_" + coldiv).innerHTML =  data[i]["name"];
                                idfloormaps='maps' + classval + "_" + rowdiv + "_" + coldiv;
                                document.getElementById('floorIdPic2_'+picNum).value=data[i]['id'];
                            }
                              changemaps(idfloormaps, data[i]['id']);
                              picNum++;
                        }
                    }
                    $('#pagination-container').pagination({
                        items: numItems,
                        itemsOnPage: perPage,
                        prevText: "&laquo;",
                        nextText: "&raquo;",
                        onPageClick: function (pageNumber) {
                            showPages(pageNumber, perPage);
                        }
                    });
                }
            });
            
        }
        function showPages(pageNo, floorOnPage) {
         a = $('#dropdownmall').val();
            $.ajax({
                type: 'GET',
                url: window.location.origin + "/getNextMap/" + a+"/"+pageNo+"/"+floorOnPage,
                beforeSend: function () {
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    var test = "";
                    var classval = $("#dropdowndisplay").val();
                    var rowdiv = 1;
                    var coldiv = 1;
                     var picNum=1;
                     $(".detailMaps").text("");
                     $('.myMapsImg').myHide();
                     if (classval == '33') {
                         for (var i = 1; i <=3 ; i++)
                        {
                            for (var x = 1; x <=3 ; x++)   
                            {    
                                $('#class' + classval + "_" + i+ "_" + x).removeClass('borderdiv');
                                $('#col' + classval + "_" + i+ "_" + x).removeClass('borderrighttext');
                                $('#col' + classval + "_" + i+ "_" + x).removeClass('bordertext');
                                $('#col' + classval + "_" + i+ "_" + x).removeClass('borderbottom');
                                $('#class' + classval + "_" + i+ "_" + x).removeClass('borderbottom');
                            }
                        }    
                     }
                     else if (classval == '32') {
                         for (var i = 1; i <=2; i++)
                        {
                            for (var x = 1; x <=3 ; x++)   
                            {    
                                 $('#class' + classval + "_" + i+ "_" + x).removeClass('borderdiv');
                                $('#col' + classval + "_" + i+ "_" + x).removeClass('borderrighttext');
                                $('#col' + classval + "_" + i+ "_" + x).removeClass('bordertext');
                                $('#col' + classval + "_" + i+ "_" + x).removeClass('borderbottom');
                                $('#class' + classval + "_" + i+ "_" + x).removeClass('borderbottom');
                            }
                        }    
                     }
                          
                    if (data.length != 0) {
                        numItems = data.length;
                        for (var i = 0; i < data.length; i++)
                        {
                            if (i % 3 == 0 && i != 0) {
                                coldiv = 1;
                                rowdiv++;
                            } else if (i != 0) {
                                coldiv++;
                            }
                            if (classval == '33' && i < 9) {
                                perPage = 9;
                                console.log("coldivx=" + coldiv);
                                console.log(rowdiv)
                                console.log(data[i]['name']);
                                document.getElementById('floorIdPic'+picNum).value=data[i]['id'];
                                
                            }else if(classval == '32' && i < 6){
                                perPage = 6;
                                document.getElementById('floorIdPic2_'+picNum).value=data[i]['id'];
                            }
                            document.getElementById('mps' + classval + "_" + rowdiv + "_" + coldiv).setAttribute('href', '' + data[i]['maps_img']);
                             $('#mps' + classval + "_" + rowdiv + "_" + coldiv).myShow();
                             $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderdiv');
                             $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('bordertext');
                            document.getElementById('mapstext' + classval + "_" + rowdiv + "_" + coldiv).innerHTML =  data[i]["name"];
                            idfloormaps='maps' + classval + "_" + rowdiv + "_" + coldiv;
                             
                             picNum++;
                            changemaps(idfloormaps, data[i]['id']);
                        } 
                        console.log("ASASA",data.length);
                        var loopdata=0;
                        if((data.length-3)<=0)loopdata=1;else loopdata =data.length-3; 
                         console.log("ASASA",loopdata);
                          coldiv = 3;
                       for (var i = data.length; i >=loopdata; i--)
                        {
                            if (i % 3 == 0 && i != 0) {
                                coldiv = 3;
                                if(i<6) 
                                    rowdiv--;
                              
                            } else if (i != 0) {
                                coldiv--;
                            }
                            if (classval == '33' && i < 9) {
                                perPage = 9;
                                console.log("coldivz=" + coldiv);
                                console.log(rowdiv)
                               
                                
                            }else if(classval == '32' && i < 6){
                                perPage = 6;
                            }
                            $('#class' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');
                            $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderbottom');
                            if (i ==data.length)
                            $('#col' + classval + "_" + rowdiv + "_" + coldiv).addClass('borderrighttext');
                            
                        } 
                        console.log();
                        if(data.length>6 && classval == '33'){
                            $('#col' + classval + '_2_3').addClass('borderrighttext');
                            $('#col' + classval + '_1_3').addClass('borderrighttext');
                        }else if(data.length>4 && classval == '32'){
                            $('#col' + classval + '_1_3').addClass('borderrighttext');
                        }
                    
                        
                    }
                    
                    
                }
                     
            });
            
        }
       

    </script>
    <script>
        
        jQuery.fn.extend({
    myShow: function () {
        return this.attr('aria-hidden', 'false').show()
    },
    myHide:function(){
        return this.attr('aria-hidden', 'true').hide()
    }
});
    </script>
</html>
