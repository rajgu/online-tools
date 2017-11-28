<div class="container">

    <div class="row page-header">
        <div class="col-lg-10 col-lg-offset-1">
            <h2 class="text-center">Whois</h2>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>Whois:</b></div></div>
                <input class="form-control readonly" type="text" id="whois">
                <div class="input-group-addon"><button id="whois_send" class="glyphicon glyphicon-save"></button></div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">


function Api_Send (data) {

    console.log ("Api_Send: ");
    console.log (data);

    var requestData = {
        "type": data['type'],
        "command": data['command'],
        "data": data['data']
    }

    console.log (requestData);

    $.ajax({
        type: "POST",
        url: "<?php echo site_url ('/api') ?>",
        data: JSON.stringify (requestData),
        success: function () { console.log(123)}
    });
}



    $( "#whois_send" ).bind ( "click", function() {

        var domainName = $("#whois").val ()
        if (/^(([a-zA-Z]{1})|([a-zA-Z]{1}[a-zA-Z]{1})|([a-zA-Z]{1}[0-9]{1})|([0-9]{1}[a-zA-Z]{1})|([a-zA-Z0-9][a-zA-Z0-9-_]{1,61}[a-zA-Z0-9]))\.([a-zA-Z]{2,6}|[a-zA-Z0-9-]{2,30}\.[a-zA-Z]{2,3})$/.test (domainName)) {

            Api_Send({
                type: "domain",
                command: "whois",
                data: {"domain": domainName}
            })


        } else {
            alert("Enter Valid Domain Name");
        }
    });
</script>