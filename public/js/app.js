(function(){
    'use strict';

    document.getElementById('preview').addEventListener('load', function(){
        this.style.display='';
        document.getElementById('loading').style.display = 'none';
        document.getElementById('getPreview').removeAttribute('disabled');
        document.getElementById('scan').removeAttribute('disabled');
    });

    document.getElementById('preview').addEventListener('click', function(){
        var canvas = document.createElement('canvas');
        canvas.width = this.naturalWidth;
        canvas.height = this.naturalHeight;
        var context = canvas.getContext('2d');
        context.drawImage(this, 0, 0 );
        canvas.toBlob(function(blob) {
            saveAs(blob, 'Scan '+new Date().toLocaleString());
        });
    });

    document.getElementById('preview').addEventListener('error', function(){
        this.removeAttribute('src');
        this.style.display='none';
        document.getElementById('loading').style.display = 'none';
        document.getElementById('getPreview').removeAttribute('disabled');
        document.getElementById('scan').removeAttribute('disabled');
    });

    function setInProgress(){
        document.getElementById('loading').style.display = '';
        document.getElementById('getPreview').setAttribute('disabled', 'disabled');
        document.getElementById('scan').setAttribute('disabled', 'disabled');
    }

    document.getElementById('getPreview').addEventListener('click', function(){
        setInProgress();
        document.getElementById('preview').src = 'api.php/preview?t=' + (+new Date()) + '&mode=' + document.forms.options.mode.value;
    });

    document.getElementById('scan').addEventListener('click', function(){
        setInProgress();
        var options = [
            'mode=' + document.forms.options.mode.value,
            'resolution=' + document.forms.options.resolution.value
        ];
        document.getElementById('preview').src = 'api.php/scan?t=' + (+new Date()) + "&" + options.join("&");
    });

})();