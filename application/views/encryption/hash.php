
<script type="text/javascript">
    $(document).ready(function () {

        $('#hash_file').bootstrapFileInput();
        $('#hash_text').keyup(function () {
            make_hashes();
        });

        $('#algorithm').change(function () {
            $('#res_md5, #res_sha1, #res_sha2-256, #res_sha2-512, #res_sha3-224, #res_sha3-256, #res_sha3-384, #res_sha3-512, #res_ripemd-160').hide ();
            if ($('#algorithm').val() == 'all') {
                $('#res_md5, #res_sha1, #res_sha2-256, #res_sha2-512, #res_sha3-224, #res_sha3-256, #res_sha3-384, #res_sha3-512, #res_ripemd-160').show();
            } else {
                $('#res_'+$('#algorithm').val()).show();
            }
            make_hashes();
        });

        function make_hashes() {
            text = $('#hash_text').val();
            if($('#hash_md5').is(':visible')) {
                $('#hash_md5').val(CryptoJS.MD5(text));
            }
            if($('#hash_sha1').is(':visible')) {
                $('#hash_sha1').val(CryptoJS.SHA1(text));
            }
            if($('#hash_sha2-256').is(':visible')) {
                $('#hash_sha2-256').val(CryptoJS.SHA256(text));
            }
            if($('#hash_sha2-512').is(':visible')) {
                $('#hash_sha2-512').val(CryptoJS.SHA512(text));
            }
            if($('#hash_sha3-224').is(':visible')) {
                $('#hash_sha3-224').val(CryptoJS.SHA3(text, { outputLength: 224 }));
            }
            if($('#hash_sha3-256').is(':visible')) {
                $('#hash_sha3-256').val(CryptoJS.SHA3(text, { outputLength: 256 }));
            }
            if($('#hash_sha3-384').is(':visible')) {
                $('#hash_sha3-384').val(CryptoJS.SHA3(text, { outputLength: 384 }));
            }
            if($('#hash_sha3-512').is(':visible')) {
                $('#hash_sha3-512').val(CryptoJS.SHA3(text, { outputLength: 512 }));
            }
            if($('#hash_ripemd-160').is(':visible')) {
                $('#hash_ripemd-160').val(CryptoJS.RIPEMD160(text));
            }
        }



/*


    sha256.update("Message Part 1");
    sha256.update("Message Part 2");
    sha256.update("Message Part 3");

    var hash = sha256.finalize();

   */









    function abortRead() {
        reader.abort();
    }


    function errorHandler(evt) {
        alert (evt.target.error.message);
        $('#progress_bar').css('width', '0%');
        $('#progress_bar_col').hide();
    }


    function updateProgress(evt) {
    //    console.log(evt.target);
    //    md5.update(evt.target.result);
        if (evt.lengthComputable) {
            var progress = Math.round((evt.loaded / evt.total) * 100);
            $('#progress_bar').css('width', progress + '%').attr('aria-valuenow', progress); 
        }
    }

    function handleFileSelect(evt) {
        $('#progress_bar').css('width', '0%');
        $('#progress_bar_col').show();

    reader = new FileReader();
    reader.onerror = errorHandler;
    reader.onprogress = updateProgress;

    reader.onloadstart = function(e) {
        var md5 = CryptoJS.algo.MD5.create();
   //   document.getElementById('progress_bar').className = 'loading';
    };

    reader.onload = function(e) {
        $('#progress_bar').css('width', '0%');
        $('#progress_bar_col').hide();
console.log (CryptoJS.MD5(e.target.result).toString());
//        console.log( md5.finalize().toString(CryptoJS.enc.Hex));
    }

    // Read in the image file as a binary string.
    reader.readAsBinaryString(evt.target.files[0]);
  }


    var md5 = CryptoJS.algo.MD5.create();
  document.getElementById('hash_file').addEventListener('change', handleFileSelect, false);











    });
</script>


<div class="container">


<div class="row page-header">
    <div class="col-lg-10 col-lg-offset-1">
        <h2 class="text-center">Hash Functions</h2>
    </div>
</div>


<div class="col-lg-10 col-lg-offset-1">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                <div class="text-right" style="width: 100px;">
                    <span class="glyphicon glyphicon-edit"></span> Text:
                </div>
            </div>
            <textarea class="form-control" rows="5" id="hash_text"></textarea>
        </div>
    </div>
</div>

<div class="col-lg-10 col-lg-offset-1">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                <div class="text-right" style="width: 100px;">
                    <span class="glyphicon glyphicon-floppy-disk"></span> File:
                </div>
            </div>
                <input type="file" data-filename-placement="inside" id="hash_file">
        </div>
    </div>
</div>


<div class="col-lg-10 col-lg-offset-1" id="progress_bar_col" style="display: none">
    <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuenow="0" aria-valuemax="100" id="progress_bar">
        </div>
    </div>
</div>


<div class="col-lg-10 col-lg-offset-1">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                <div class="text-right" style="width: 100px">
                    <span class="glyphicon glyphicon-flash"></span> Algorithm:
                </div>
            </div>
            <select class="form-control" id="algorithm">
                <option value="all">All</option>
                <option value="md5">MD5</option>
                <option value="sha1">SHA1</option>
                <option value="sha2-256">SHA2(256)</option>
                <option value="sha2-512">SHA2(512)</option>
                <option value="sha3-224">SHA3(224)</option>
                <option value="sha3-256">SHA3(256)</option>
                <option value="sha3-384">SHA3(384)</option>
                <option value="sha3-512">SHA3(512)</option>
                <option value="ripemd-160">RIPEMD-160</option>
            </select>
        </div>
    </div>
</div>





<div class="col-lg-12" id="res_md5">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>MD5:</b></div></div>
            <input class="form-control readonly" type="text" id="hash_md5">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_sha1">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>SHA1:</b></div></div>
            <input class="form-control readonly" type="text" id="hash_sha1">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_sha2-256">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>SHA2(256):</b></div></div>
            <input class="form-control readonly" type="text" id="hash_sha2-256">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_sha2-512">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>SHA2(512):</b></div></div>
            <input class="form-control readonly" type="text" id="hash_sha2-512">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_sha3-224">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>SHA3(224):</b></div></div>
            <input class="form-control readonly" type="text" id="hash_sha3-224">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_sha3-256">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>SHA3(256):</b></div></div>
            <input class="form-control readonly" type="text" id="hash_sha3-256">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_sha3-384">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>SHA3(384):</b></div></div>
            <input class="form-control readonly" type="text" id="hash_sha3-384">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_sha3-512">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>SHA3(512):</b></div></div>
            <input class="form-control readonly" type="text" id="hash_sha3-512">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

<div class="col-lg-12" id="res_ripemd-160">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon" style="width: 120px"><div class="text-right"><b>RIPEMD-160:</b></div></div>
            <input class="form-control readonly" type="text" id="hash_ripemd-160">
            <div class="input-group-addon"><button class="glyphicon glyphicon-floppy-disk"></button></div>
        </div>
    </div>
</div>

</div>
