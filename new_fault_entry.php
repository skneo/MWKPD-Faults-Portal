<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['machine'])) {
    $machine = $_GET['machine'];
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <!-- for tinymce -->
    <!-- <script src='tinymce/tinymce.min.js'></script> -->
    <script src="https://cdn.tiny.cloud/1/e6aiwxkshssibfqngwx0wxkxnemniy9m7h9x7143hhate0zf/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <title>New Fault Entry</title>
</head>

<body>
    <?php
    include 'header.php';
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <div class="container my-3">
        <h4><?php
            echo "New fault entry for $machine";
            ?></h4>
        <?php
        echo "<form method='POST' action=fault_history.php?machine=$machine";
        ?>
        <div class="container my-3">
            <div class='mb-3'>
                <label for='date' class='form-label float-start text-success'>Date of fault</label>
                <input type='date' class='form-control' id='datetime' name='datetime' required>
            </div>
            <div class='mb-3'>
                <label for='main_part' class='form-label float-start text-success'>Main part of machine affected</label>
                <textarea class='form-control' rows="2" id='main_part' name='main_part' required></textarea>
            </div>
            <div class='mb-3'>
                <label for='fault_desc' class='form-label float-start text-success'>Fault Description</label>
                <textarea class='form-control' rows="3" id='fault_desc' name='fault_desc' required></textarea>
            </div>
            <div class='mb-3'>
                <label for='rectification' class='mb-2 text-success'>Rectification Steps taken</label><br>
                <div>

                    <textarea class='form-control' rows="5" id='rectification' name='rectification'></textarea>
                </div>
                <script>
                    tinymce.init({
                        setup: function(ed) {
                            ed.on('change', function(e) {
                                // This will print out all your content in the tinyMce box
                                console.log('the content ' + ed.getContent());
                                // Your text from the tinyMce box will now be passed to your  text area ... 
                                $("rectification").text(ed.getContent());
                            });
                        },
                        selector: 'textarea#rectification',

                        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                        imagetools_cors_hosts: ['picsum.photos'],
                        menubar: 'file edit view insert format tools table help',
                        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                        toolbar_sticky: true,
                        autosave_ask_before_unload: true,
                        autosave_interval: "30s",
                        autosave_prefix: "{path}{query}-{id}-",
                        autosave_restore_when_empty: false,
                        autosave_retention: "2m",
                        image_advtab: true,
                        /*content_css: '//www.tiny.cloud/css/codepen.min.css',*/
                        link_list: [{
                                title: 'My page 1',
                                value: 'https://www.codexworld.com'
                            },
                            {
                                title: 'My page 2',
                                value: 'https://www.xwebtools.com'
                            }
                        ],
                        image_list: [{
                                title: 'My page 1',
                                value: 'https://www.codexworld.com'
                            },
                            {
                                title: 'My page 2',
                                value: 'https://www.xwebtools.com'
                            }
                        ],
                        image_class_list: [{
                                title: 'None',
                                value: ''
                            },
                            {
                                title: 'Some class',
                                value: 'class-name'
                            }
                        ],
                        importcss_append: true,
                        file_picker_callback: function(callback, value, meta) {
                            /* Provide file and text for the link dialog */
                            if (meta.filetype === 'file') {
                                callback('https://www.google.com/logos/google.jpg', {
                                    text: 'My text'
                                });
                            }

                            /* Provide image and alt text for the image dialog */
                            if (meta.filetype === 'image') {
                                callback('https://www.google.com/logos/google.jpg', {
                                    alt: 'My alt text'
                                });
                            }

                            /* Provide alternative source and posted for the media dialog */
                            if (meta.filetype === 'media') {
                                callback('movie.mp4', {
                                    source2: 'alt.ogg',
                                    poster: 'https://www.google.com/logos/google.jpg'
                                });
                            }
                        },
                        templates: [{
                                title: 'New Table',
                                description: 'creates a new table',
                                content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
                            },
                            {
                                title: 'Starting my story',
                                description: 'A cure for writers block',
                                content: 'Once upon a time...'
                            },
                            {
                                title: 'New list with dates',
                                description: 'New List with dates',
                                content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
                            }
                        ],
                        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
                        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
                        height: 600,
                        image_caption: true,
                        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                        noneditable_noneditable_class: "mceNonEditable",
                        toolbar_mode: 'sliding',
                        contextmenu: "link image imagetools table",
                    });
                </script>
                <!-- <a href="https://onlinehtmleditor.dev/" class='me-3' target='blank'>Rich text edtor</a> -->
                <a href="https://t.me/+ck6veEJeSwg3YjU9" target='blank'>Upload files on Telegram in KPD Pit Wheel Lathe group</a>
            </div>
            <div class='mb-3'>
                <label for='components' class='form-label float-start text-success'>Any component new/replaced</label>
                <textarea class='form-control' id='components' name='components' required></textarea>
            </div>
            <button type='submit' class='btn btn-primary'>Submit</button>
            </form>
        </div>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>