//Server
/*
if (typeof (base_url) == "undefined") {
    var base_url = location.protocol + '//' + location.host + '/';
    const LOCAL_DOMAINS = ["localhost", "127.0.0.1"];
    if (LOCAL_DOMAINS.includes(window.location.hostname)) {
        var tbpKey = 'tAj3ykawOTzO195azIrI39QGO5Hf4oY37yt/mvVWDB6lF4mbMehmUtXoZAq7dczpwFB6245UHnwEf1CiYCb4SINcPS3aYAv/RC/tLY8Zkx4='; // replace with your localhost key
    } else {
        var tbpKey = 'HzV9mtcnFy6VCLwfjmWGKanocR9xc4CviCaJEzNlVOxkEcem8sf7PKvx4KtDb+/bAOq9OcAqQaLL5FR26Ckc2oyULskC3Ftv6qo3j3YYVEw='; // replace with your production server key
    }
}
tinymce.init({
    selector: '#mytextarea',
    plugins: ['bootstrap','code','emoticons','anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss'],
    toolbar: ['undo redo | anchor blocks fontfamily fontsize | emoticons code | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | charmap | removeformat','bootstrap'],
    contextmenu: ['bootstrap'],
    bootstrapConfig: {
        url: base_url + 'admin/assets/libs/tinymce/tinymce-bootstrap-plugin/bootstrap5/plugin/',
        iconFont: 'font-awesome-solid',
        imagesPath: '/media/gallery',
        key: tbpKey
    },
    height : 500,
    tinycomments_mode: 'embedded',
    mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
});
*/

// Local 

if (typeof (base_url) == "undefined") {
    var base_url = location.protocol + '//' + location.host + '/';
    const LOCAL_DOMAINS = ["localhost", "127.0.0.1"];
    if (LOCAL_DOMAINS.includes(window.location.hostname)) {
        var tbpKey = 'tAj3ykawOTzO195azIrI39QGO5Hf4oY37yt/mvVWDB6lF4mbMehmUtXoZAq7dczpwFB6245UHnwEf1CiYCb4SINcPS3aYAv/RC/tLY8Zkx4='; // replace with your localhost key
    } else {
        var tbpKey = 'HzV9mtcnFy6VCLwfjmWGKanocR9xc4CviCaJEzNlVOxkEcem8sf7PKvx4KtDb+/bAOq9OcAqQaLL5FR26Ckc2oyULskC3Ftv6qo3j3YYVEw='; // replace with your production server key
    }
}
tinymce.init({
    selector: '#mytextarea',
    plugins: ['bootstrap','code','emoticons','anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss'],
    toolbar: ['undo redo | anchor blocks fontfamily fontsize | emoticons code | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | charmap | removeformat','bootstrap'],
    contextmenu: ['bootstrap'],
    bootstrapConfig: {
        url: base_url + 'emtsk/admin/assets/libs/tinymce/tinymce-bootstrap-plugin/bootstrap5/plugin/',
        iconFont: 'font-awesome-solid',
        imagesPath: '/emtsk/media/gallery',
        key: tbpKey
    },
    height : 530,
    tinycomments_mode: 'embedded',
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
});
