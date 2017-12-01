<div class="container">

    <div class="row page-header">
        <div class="col-lg-10 col-lg-offset-1">
            <h2 class="text-center">Dropped</h2>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>Domain Search:</b></div></div>
                <input class="form-control" type="text" id="dropped">
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
        "params": data['params']
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
                params: {"domain": domainName}
            })


        } else {
            alert("Enter Valid Domain Name");
        }
    });
</script>