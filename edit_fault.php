<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0' crossorigin='anonymous'>
    <!-- for tinymce -->
    <!-- <script src='tinymce/tinymce.min.js'></script> -->
    <script src="https://cdn.tiny.cloud/1/e6aiwxkshssibfqngwx0wxkxnemniy9m7h9x7143hhate0zf/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <title>Edit fault</title>
</head>

<body>
    <?php include 'header.php';
    if (isset($_GET['edit_fault_id'])) {
        $id = $_GET['edit_fault_id'];
        include_once 'db_con.php';
        $sql = "SELECT * FROM `faults` WHERE `id`='$id'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $occured_on = $row['occured_on'];
        $main_part = $row['main_part'];
        $fault_desc = $row['fault_desc'];
        $rectification = $row['rectification'];
        $components = $row['components'];
        // echo $date;
    }
    ?>
    <div class="container my-3">
        <h4 class="my-3">Edit fault id <?php echo $id ?> </h4>
        <form action="fault.php?fault_id=<?php echo $id ?>" method="POST">
            <div class="mb-3">
                <label for="datetime" class="form-label float-start text-success">Date</label>
                <input class="form-control " type="date" name="datetime" id="datetime" value='<?php echo $occured_on ?>'>
            </div>
            <div class='mb-3'>
                <label for='main_part' class='form-label float-start text-success'>Main part affected</label>
                <textarea class='form-control' rows="2" id='main_part' name='main_part' required><?php echo $main_part ?></textarea>
            </div>
            <div class='mb-3'>
                <label for='edit_fault_desc' class='form-label float-start text-success'>Fault Description</label>
                <textarea class='form-control' rows="3" id='edit_fault_desc' name='edit_fault_desc' required><?php echo $fault_desc ?></textarea>
            </div>
            <div class='mb-3'>
                <label for='rectification' class='mb-2 text-success'>Rectification Steps taken</label><br>
                <div>

                    <textarea class='form-control' rows="5" id='rectification' name='rectification'><?php echo $rectification ?> </textarea>
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
                <a href="https://t.me/+ck6veEJeSwg3YjU9" target='blank'>Upload files on Telegram in KPD Pit Wheel Lathe group</a>
            </div>

            <div class='mb-3'>
                <label for='components' class='form-label float-start text-success'>Any component new/replaced</label>
                <textarea class='form-control' id='components' name='components' required><?php echo $components ?></textarea>
            </div>
            <input type="submit" class="btn btn-primary mt-2">

        </form>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8' crossorigin='anonymous'></script>
</body>

</html>