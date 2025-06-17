const upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', 'ajax/api.tinyupload.php');
    xhr.upload.onprogress = (e) => {
        progress(e.loaded / e.total * 100);
    };
    xhr.onload = () => {
        if (xhr.status === 403) {
            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
            return;
        }
        if (xhr.status < 200 || xhr.status >= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
        }
        const json = JSON.parse(xhr.responseText);
        if (!json || typeof json.location != 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
        }
        resolve(json.location);
    };
    xhr.onerror = () => {
        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
    };
    const formData = new FormData();
    formData.append('agnd_img_upload', blobInfo.blob(), blobInfo.filename());
    formData.append('upload', true);
    xhr.send(formData);
});

tinymce.init({
    selector: '#mytextarea',
    menubar: true,
    plugins : ['image','anchor','charmap','code','table','emoticons','link','lists','media','wordcount','visualblocks'],
    toolbar: ['fontfamily fontsize | bold italic underline strikethrough removeformat | alignleft aligncenter alignright alignjustify ', 
                'undo redo | image findImg media | emoticons code table link unlink lists bullist numlist | visualblocks'],
    height : 500,        
    images_upload_handler: upload_handler,
    setup : function(ed) {
        ed.ui.registry.addButton('findImg', {
            icon: 'search',
            tooltip: 'Resmi Düzenle',
            onAction: function (api, e) {
                $('#searcFile').modal('show');
                //modal z-index
                $('#searcFile').css('z-index', 2000);
            }
        });
        window.insertImage = function(src){
            tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="'+src+'" style="max-width: 100%; height: auto;">');
        }


    }
});  

/*
!function(e){"function"==typeof define&&define.amd?define(e):e()}(function(){var e,t=["scroll","wheel","touchstart","touchmove","touchenter","touchend","touchleave","mouseout","mouseleave","mouseup","mousedown","mousemove","mouseenter","mousewheel","mouseover"];if(function(){var e=!1;try{var t=Object.defineProperty({},"passive",{get:function(){e=!0}});window.addEventListener("test",null,t),window.removeEventListener("test",null,t)}catch(e){}return e}()){var n=EventTarget.prototype.addEventListener;e=n,EventTarget.prototype.addEventListener=function(n,o,r){var i,s="object"==typeof r&&null!==r,u=s?r.capture:r;(r=s?function(e){var t=Object.getOwnPropertyDescriptor(e,"passive");return t&&!0!==t.writable&&void 0===t.set?Object.assign({},e):e}(r):{}).passive=void 0!==(i=r.passive)?i:-1!==t.indexOf(n)&&!0,r.capture=void 0!==u&&u,e.call(this,n,o,r)},EventTarget.prototype.addEventListener._original=e}});
//# sourceMappingURL=index.umd.js.map
*/