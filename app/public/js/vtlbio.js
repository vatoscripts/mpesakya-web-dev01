var CapturedData = "";
var CapturedFinger = "";

function VTLBion() {
    this.Init = function(divID) {
        var htm = '<div style="margin:2em">';
        htm += "  <table >";
        htm += ' <tr valign="top"> <td>';
        htm += ' <div class="backgroundA"  >';
        htm +=
            ' <input id="Radio1" name="rdoFinger" onchange="getFingerName(this)" type="radio"  style ="position:absolute; top: 49px; left: -9px;"/>';
        htm +=
            '  <input id = "Radio2" type = "radio" name = "rdoFinger" onchange="getFingerName(this)" style = "position:absolute; top: -4px; left: 35px; height: 20px;" />';
        htm +=
            '        <input id="Radio3" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: -17px; left: 95px;" />';
        htm +=
            '        <input id="Radio4" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: -1px; left: 164px;" />';
        htm +=
            '     <input id="Radio5" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: 125px; left: 219px;" />';
        htm +=
            '        <input id="Radio6" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: 125px; left: 259px; width: 20px;" />';
        htm +=
            '       <input id="Radio7" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: -1px; left: 315px;" />';
        htm +=
            '        <input id="Radio8" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: -17px; left: 381px;" />';
        htm +=
            '        <input id="Radio9" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: 0px; left: 446px;" />';
        htm +=
            '       <input id="Radio10" type="radio" name="rdoFinger" onchange="getFingerName(this)" style="position:absolute; top: 45px; left: 485px; height: 20px;" />';
        htm +=
            '       <div id="lblCapture"   style="position:absolute; top: 200px; left: 218px; "><b>Select Finger<b></div>';
        htm +=
            '     <input id = "Button1" type = "button" value = "Capture Fingerprint" class="btn btn-danger"  onclick = "Capture()" style = "position:relative; top: 229px; left: 190px;" />';
        htm += " </div ></td >";

        htm += '     <td style="padding:10px">';
        htm +=
            '     <div class="row"><div class="col-sm-12" style="margin-bottom:10px;">';
        htm +=
            '         <img id="FingerImage" src=" " style="height:130px; min-width:140px; border:solid 1px #CCCCCC;" />';
        htm += '     </div></div>  <div class="row"><div class="col-sm-12">';
        htm +=
            '     <input id = "Button1" type = "button" value = "Reset Fingerprint" class="btn btn-default" onclick="ResetCaptureImage()" /></div></div>';

        htm += "    </td>";
        htm += "        </tr >";
        htm += "     </table >";

        htm += "  </div >";
        if (window.screen.width > 720) {
            $("#" + divID).html(htm);
        } else {
            var htm1 = ' <div class="row" >';
            htm1 += ' <div class="col-xs-12 col-md-12">';

            htm1 += ' <div class="form-group">';

            htm1 +=
                '     <select class="form-control" onchange="dropFingerSelected(this)">';
            htm1 += '       <option value="">Choose Finger</option>';
            htm1 += '         <option value="L5">Left Little</option>';
            htm1 += '        <option value="L4">Left Ring</option>';
            htm1 += '         <option value="L3">Left Middle</option>';
            htm1 += '         <option value="L2">Left Index</option>';
            htm1 += '      <option value="L1">Left Thumb</option>';
            htm1 += '      <option value="">---------</option>';
            htm1 += '       <option value="R5">Right Little</option>';
            htm1 += '       <option value="R4">Right Ring</option>';
            htm1 += '       <option value="R3">Right Middle</option>';
            htm1 += '       <option value="R2">Right Index</option>';
            htm1 += '       <option value="R1">Right Thumb</option>';
            htm1 += "    </select>";
            htm1 += " </div>";
            htm1 +=
                '     <input type="button" class="btn btn-block btn-info" onclick = "Capture()"  value="CAPTURE FINGER PRINT" />';
            htm1 += '    <div style=" margin-top:10px" >';
            htm1 +=
                '       <img id="FingerImage" style="height:300px; width:100%; border:1px dashed #CCCCCC;" src=" " />';
            htm1 += "    </div>";
            htm1 += "   </div>";
            htm1 += "  </div>";

            $("#" + divID).html(htm1);
        }
    };
    this.FingerPrintData = CapturedData;
    this.FingerName = CapturedFinger;
}

function dropFingerSelected(e) {
    CapturedFinger = e.value;
    console.log(CapturedFinger);
}

function getFingerName(e) {
    if (e.id == "Radio1") {
        $("#lblCapture").html("Left Little");
        document.getElementById("fingerCode").value = "L5";
        //document.getElementById("fingerCode").value = response;
    }
    if (e.id == "Radio2") {
        $("#lblCapture").html("Left Ring");
        document.getElementById("fingerCode").value = "L4";
    }
    if (e.id == "Radio3") {
        $("#lblCapture").html("Left Middle");
        document.getElementById("fingerCode").value = "L3";
    }
    if (e.id == "Radio4") {
        $("#lblCapture").html("Left Index");
        document.getElementById("fingerCode").value = "L2";
    }
    if (e.id == "Radio5") {
        $("#lblCapture").html("Left Thumb");
        document.getElementById("fingerCode").value = "L1";
    }

    if (e.id == "Radio6") {
        $("#lblCapture").html("Right Thumb");
        document.getElementById("fingerCode").value = "R1";
    }
    if (e.id == "Radio7") {
        $("#lblCapture").html("Right Index");
        document.getElementById("fingerCode").value = "R2";
    }
    if (e.id == "Radio8") {
        $("#lblCapture").html("Right Middle");
        document.getElementById("fingerCode").value = "R3";
    }

    if (e.id == "Radio9") {
        $("#lblCapture").html("Right Ring");
        document.getElementById("fingerCode").value = "R4";
    }
    if (e.id == "Radio10") {
        $("#lblCapture").html("Right Little");
        document.getElementById("fingerCode").value = "R5";
    }
}

function Capture() {
    // if (CapturedFinger == "") {
    //     $("#lblCapture").html("<b>Select Finger<b>");
    //     return;
    // }
    var settings = {
        async: true,
        crossDomain: true,
        url: "http://localhost:2019/",
        method: "GET"
    };

    $.ajax(settings).done(function(response) {
        var el = document.getElementById("FingerImage");

        if (response != "") {
            CapturedData = response;
            document.getElementById("fingerData").value = response;
            el.src = "data:image/png;base64," + response;
        } else {
            CapturedData = "";
            el.src = " ";
        }
    });
}

function ResetCaptureImage() {
    var el = document.getElementById("FingerImage");
    CapturedData = "";
    el.src = " ";
}
