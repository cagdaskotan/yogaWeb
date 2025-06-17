<?php
if (isset($_POST['htms-content'])) {
    // sanitize & secure the posted HTML
    // https://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm
    include_once 'htmLawed.php';
    $config = array(
        'comment'       => 1,
        'cdata'         => 1,
        'clean_ms_char' => 1,
        'keep_bad'      => 1,
        "safe"          => 1
    );
    $spec = '* = aria-*, data-*, role;';
    $processed = htmLawed($_POST['htms-content'], $config, $spec);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tinymce Bootstrap Plugin - PHP Form Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Gilles Migliori">
    <meta name="copyright" content="miglisoft">
    <meta name="description" content="Tinymce Textarea with Bootstrap 4 toolbar - post the form to load the textarea content on your page and test your content on the fly.">
    <meta name="language" content="en">
    <meta name="robots" content="noindex, nofollow">
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Tinymce -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.1/tinymce.min.js" integrity="sha512-WVGmm/5lH0QUFrXEtY8U9ypKFDqmJM3OIB9LlyMAoEOsq+xUs46jGkvSZXpQF7dlU24KRXDsUQhQVY+InRbncA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap plugin -->
    <script src="../../plugin/plugin.js"></script>
</head>

<body class="d-flex flex-column justify-content-between" style="min-height: 100vh">

    <?php if (!isset($_POST['htms-content'])) { ?>
        <div class="container pt-4">
            <h1 class="text-secondary font-weight-light text-center mb-4">Tinymce Bootstrap Plugin<br><small>PHP Form Demo</small></h1>

            <p class="lead mb-2">Enter your content in the Tinymce editor then validate to display the result.</p>

            <p class="lead">This page loads jQuery and Bootstrap Javascript. It allows you to test Javascript functionalities such as Modal, Collapse, Dropdown, Popover, etc...</p>

            <!--=====================================
            =                  Form                 =
            ======================================-->

            <form method="POST">
                <div class="form-group">
                    <textarea name="htms-content" class="tinymce" style="min-height:50vh"></textarea>
                </div>
                <div class="form-group text-center mt-5">
                    <button type="submit" class="btn btn-lg btn-success">Submit <i class="fas fa-envelope ms-2"></i></button>
                </div>
            </form>
        </div>

        <!--=========  End of Form  =========-->

        <?php
    } elseif (isset($processed)) { ?>
        <!--=====================================
        =                Output                 =
        ======================================-->
        <h1 class="text-secondary font-weight-light text-center my-4">Tinymce Bootstrap Plugin<br><small>Posted Bootstrap 4 HTML</small></h1>
        <div id="output"><?php echo $processed; ?></div>

        <p class="text-center">
            <button type="button" onclick="window.location = window.location.href;" class="btn btn-lg btn-primary">Reload the editor <i class="fas fa-sync ms-2"></i></button>
        </p>

        <!--=======  End of Output  =========-->

        <?php
    } ?>

    <p class="text-center mt-4"><a href="https://www.tinymce-bootstrap-plugin.com/" title="Tinymce Bootstrap plugin">&COPY; Tinymce Bootstrap plugin</a></p>
    <script src="https://kit.fontawesome.com/dc840779d0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        if (typeof(base_url) == "undefined") {
            var base_url = location.protocol + '//' + location.host + '/';

            const LOCAL_DOMAINS = ["localhost", "127.0.0.1", 'tinymce-bootstrap-plugin-scratch'];
            if (LOCAL_DOMAINS.includes(window.location.hostname)) {
                var tbpKey = 'chty0ssnHokCWxzrCoF41/nCKWDH3zF7cLo5Xb3jTABH4Mdok+seIAin4kOc3eAUfbLI0oMsREGyaseCZA1OIxbra2WnAFW9ycKpCktLR9ZoDDz78MMq08KJws/NdPhJ';
            } else {
                var tbpKey = 'production-key-here';
            }
        }
        // uncomment the following line to test if your key is properly set
        // console.log(tbpKey);
        tinymce.init({
            // language: 'fr_FR',
            // language_url :'/bootstrap5/plugin/langs/fr_FR.js',
            selector: 'textarea.tinymce',
            toolbar_mode: 'wrap',
            plugins: 'advlist autolink bootstrap link image lists charmap preview help table',
            toolbar: [
                'undo redo | bootstrap',
                'cut copy paste | styles | alignleft aligncenter alignright alignjustify | bold italic | link image | preview | help'
            ],
            contextmenu: "link image imagetools table spellchecker | bootstrap",
            file_picker_types: 'file image media',
            bootstrapConfig: {
                // language: 'fr_FR',
                url: base_url + 'bootstrap5/plugin/',
                iconFont: 'font-awesome-solid',
                imagesPath: '/bootstrap5/demo/demo-images',
                key: tbpKey,
                enableTemplateEdition: false
            },
            styles: {
                alignleft: {
                    selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img',
                    classes: 'text-start'
                },
                aligncenter: {
                    selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img',
                    classes: 'text-center'
                },
                alignright: {
                    selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img',
                    classes: 'text-end'
                },
                alignjustify: {
                    selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img',
                    classes: 'text-justify'
                },
                bold: {
                    inline: 'strong'
                },
                italic: {
                    inline: 'em'
                },
                underline: {
                    inline: 'u'
                },
                sup: {
                    inline: 'sup'
                },
                sub: {
                    inline: 'sub'
                },
                strikethrough: {
                    inline: 'del'
                }
            },
            style_formats: [{
                    title: 'Headings',
                    items: [{
                            title: 'Heading 1',
                            format: 'h1'
                        },
                        {
                            title: 'Heading 2',
                            format: 'h2'
                        },
                        {
                            title: 'Heading 3',
                            format: 'h3'
                        },
                        {
                            title: 'Heading 4',
                            format: 'h4'
                        },
                        {
                            title: 'Heading 5',
                            format: 'h5'
                        },
                        {
                            title: 'Heading 6',
                            format: 'h6'
                        }
                    ]
                },
                {
                    title: 'Blocks',
                    items: [{
                            title: 'Paragraph',
                            format: 'p'
                        },
                        {
                            title: 'Blockquote',
                            format: 'blockquote'
                        },
                        {
                            title: 'Div',
                            block: 'div',
                            wrapper: true
                        }
                    ]
                },
                {
                    title: 'Containers',
                    items: [{
                            title: 'Container fluid',
                            block: 'div',
                            classes: 'container-fluid',
                            wrapper: true
                        },
                        {
                            title: 'Container',
                            block: 'div',
                            classes: 'container',
                            wrapper: true
                        },
                        {
                            title: 'Section',
                            block: 'section',
                            wrapper: true
                        },
                        {
                            title: 'Article',
                            block: 'article',
                            wrapper: true
                        }
                    ]
                }
            ],
            style_formats_merge: false,
            style_formats_autohide: true
        });
    </script>
</body>

</html>
