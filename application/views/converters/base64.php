


<div class="container">

<div class="row page-header">
    <div class="col-lg-10 col-lg-offset-1">
        <h2 class="text-center">Base64 Encode / Decode</h2>
    </div>
</div>


<div class="col-lg-10 col-lg-offset-1">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                <div class="text-right" style="width: 100px;">
                    <span class="glyphicon glyphicon-edit"></span> Plain Text:
                </div>
            </div>
            <textarea class="form-control" rows="6" id="input_plain_text"></textarea>
        </div>
    </div>
</div>

<div class="col-lg-10 col-lg-offset-1">
    <div class="form-group">
        <div class="input-group">
            <button type="button" class="btn btn-lg btn-default" id="btn_encode"><span class="glyphicon glyphicon-arrow-down"></span> ENCODE</button>
            <button type="button" class="btn btn-lg btn-default" id="btn_decode"><span class="glyphicon glyphicon-arrow-up"></span> DECODE</button>
        </div>
    </div>
</div>

<div class="col-lg-10 col-lg-offset-1">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                <div class="text-right" style="width: 100px;">
                    <span class="glyphicon glyphicon-edit"></span> Base64 Text:
                </div>
            </div>
            <textarea class="form-control" rows="6" id="input_base64"></textarea>
        </div>
    </div>
</div>


</div>



<script type="text/javascript">
$('#btn_decode').bind( "click", function() {
	$("#input_plain_text").val ('');
    var decoded = CryptoJS.enc.Base64.parse($("#input_base64").val());
    $("#input_plain_text").val(decoded.toString (CryptoJS.enc.Utf8));
});

$('#btn_encode').bind( "click", function() {
	$("#input_base64").val ('');
	var text = CryptoJS.enc.Utf8.parse ($("#input_plain_text").val());
    var encoded = CryptoJS.enc.Base64.stringify(text);
    $("#input_base64").val(encoded);
});
</script>