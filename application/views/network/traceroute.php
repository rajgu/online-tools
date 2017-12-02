<div class="container">

    <div class="row page-header">
        <div class="col-lg-10 col-lg-offset-1">
            <h2 class="text-center">Traceroute</h2>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>Host:</b></div></div>
                <input class="form-control readonly" type="text" id="host">
                <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-lg-offset-2">
        <div class="form-group">
            <div class="input-group pull-left">
                <button type="button" class="btn btn-lg btn-default" id="btn_encode"><span class="glyphicon glyphicon-arrow-down"></span> TRACE</button>
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