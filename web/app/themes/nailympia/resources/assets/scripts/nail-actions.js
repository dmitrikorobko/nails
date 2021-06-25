 /* eslint-disable */
jQuery(document).ready(function($){


    $('.image_uploaded-video').click(function(e){
 
        var src = $(this).attr('data-src');
        $.fancybox.open({


            beforeLoad : function(data) {

                console.log(data)


                // Check if quictime movie and change content
                 if (src.indexOf('.mov') != -1) {
                    //this.content    = '<object width="100" height="200" pluginspage="http://www.apple.com/quicktime/download" data="'+ src + '" type="video/quicktime"><param name="autoplay" value="true"><param name="scale" value="tofit"><param name="controller" value="true"><param name="enablejavascript" value="true"><param name="src" value="' + src  + '"><param name="loop" value="false"></object>';
                   

                    this.content = '<video controls width="820" height="440" src="'+ src +'"></video>'
                   
                    this.type       = 'html';
                 } else {
                     this.src   =  src;
                     this.type       = 'video';
                 }
            }

        })
    })



    $('.fancybox').fancybox({
        // src  : $(),
        // beforeLoad : function(data) {
        //
        //     console.log(data)
        //
        //
        //     // Check if quictime movie and change content
        //     if (data.current.src.indexOf('.mov') != -1) {
        //         this.content    = '<object width="100" height="200" pluginspage="http://www.apple.com/quicktime/download" data="'+ data.current.src + '" type="video/quicktime"><param name="autoplay" value="true"><param name="scale" value="tofit"><param name="controller" value="true"><param name="enablejavascript" value="true"><param name="src" value="' + data.current.src + '"><param name="loop" value="false"></object>';
        //
        //     }
        // }
    })


    $('.custom-file-preview-del').click(function(){
        $(this).next('img').addClass('hidden').attr('src', '')
        $(this).addClass('hidden')
        $(this).closest('.contest').find('input').val('')

        $('.user_nominations_form .btn').click();
    })



    // $('.fancybox ').click(function(e){
    //     e.stopPropagation();
    //     e.stopImmediatePropagation()
    //     e.preventDefault();
    //
    //     var src = $(this).attr('data-src')
    //
    //     $.fancybox.open({
    //         src  : src,
    //
    //
    //     });
    //
    //     return false
    // })

    var Dropzone = window.Dropzone;
    if(Dropzone)
        Dropzone.autoDiscover = false;

    $('.nominations ul li .dropzones').each(function () {
        var loop = $(this).closest('li').data('loop');
        var type = $(this).data('type');
        var i = type == 'image' ? $(this).data('i') : '';

        var dropzones = $(this);
        var preview = "img.image_uploaded-" + type + loop + i;
        var $inputDZ =  $(this).closest('li').find('input.dz-'  + type + loop + i);

        var acceptedFiles = type == 'video' ? 'video/*' : "image/*";



        dropzones.dropzone({
            //      autoProcessQueue: false,
            //   autoQueue: false,
            url: form_global.url + '?action=submit_dropzonejs',
            maxFiles: 1,
            thumbnailHeight: 100,

            acceptedFiles: acceptedFiles,


            init: function(e) {



                var myDropzone = this;


                // document.getElementById("submit").addEventListener("click", function(e) {
                //     // Make sure that the form isn't actually being sent.
                //     e.preventDefault();
                //     e.stopPropagation();
                //     myDropzone.processQueue();
                // });



                this.on("thumbnail", function(thumbnail, url) {
                    console.log(thumbnail);

                    if (type !== 'video')
                        $(preview).attr('src', url);





                })



                this.on("sending", function(files, xhr, formData) {


                    $('.preloader')
                        .html(form_global.preloader)
                        .addClass('loading')

                    console.log('Sending..');

                    $(preview).removeClass('hidden')
                    $(preview).parent().find('span').removeClass('hidden')

                    $(preview).parent().addClass('loading')




                    if (type == 'video') {
                        src = form_global.placeholder
                        $(preview).attr('src', src);
                    }

                    else
                        $(preview).addClass('fancybox')
                    
                    $('.btn').prop('disabled', true)



                });

                this.on("success", function(file, data) {

                    console.log(data);

                    $inputDZ.val(data.id);

                    var src = data.src;

                    if (type == 'video')
                        src = form_global.placeholder
					console.log(data.url);
                    $(preview).attr('src', src);
                    $(preview).attr('data-src', data.url);

                    $('.preloader').html('')

                    $('.btn').prop('disabled', false);

                    var that = this

                    $('.custom-file-preview-del').click(function(){
                        $(this).next('img').addClass('hidden').attr('src', '')
                        $(this).addClass('hidden')
                        $(this).closest('.contest').find('input').val('')

                        that.removeFile(file);

                        $('.user_nominations_form .btn').click();
                    })


                    $('.user_nominations_form .btn').click();

                    $('.fancybox ').fancybox()



                });


                this.on("removedfile", function(file) {

                    // console.log(file.id);
                });


                this.on("successmultiple", function(file, response) {
                    // get response from successful ajax request
                    console.log(response);
                    // submit the form after images upload
                    // (if u want yo submit rest of the inputs in the form)
                    //   document.getElementById("dropzone-form").submit();
                });



            }


        });

    })




    $(document).on('submit', '.user_nominations_form',  function(e){
        e.preventDefault();

    })



    $(document).on('click', '.user_nominations_form .btn',  function(e){
        e.preventDefault();

        $('.preloader').html(form_global.preloader)
            .addClass('loading')

        var data = $('.user_nominations_form').serialize()

        var form = jQuery('.user_nominations_form')[0];
        var form_data = new FormData(form);

        $('[type="file"]').each(function(){
            var file_data = $(this)[0];
            form_data.append('file', file_data);
        })




        $.ajax({
            type: 'post',
            url: form_global.url,
            data: form_data,
            //  dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,



            success: function (data) {
                console.log(data);

                $('.media-item').removeClass('loading')
                $('.preloader').html('done').removeClass('loading')
            }
        });

    })






    $(document).on('click', '[data-remove_id]',  function(e){
        e.preventDefault();


        $(this).closest('.contest').find('input').val('')
        $(this).closest('figure').remove();


        //
        // $.ajax({
        //     type: 'post',
        //     url: form_global.url,
        //     data: data,
        //     dataType: 'json',
        //
        //
        //     success: function (data) {
        //         console.log(data);
        //
        //         $('.preloaded').html('done')
        //     }
        // });

    })


    //admin form

    $(document).on('change', '[name="participant"]',  function(e){
        e.preventDefault();

        var val = $(this).val();

        $('.nominations_criteries').html('');

        $('.user_nominations').html(form_global.preloader);

        $.ajax({
            type: 'get',
            url: form_global.url,
            data: {
                action:'select_participant',
                user_id:val
            },
            dataType: 'json',


            success: function (data) {
                console.log(data);

                $('.user_nominations').html(data.data)
                $('.user_nominations').append(data.msg)
            }
        });

    })


    $(document).on('change', '[name="nomination"]',  function(e){
        e.preventDefault();

        var val = $(this).val();
        var user_id = $('#participant').val()

        $('.nominations_criteries').html(form_global.preloader);

        $.ajax({
            type: 'get',
            url: form_global.url,
            data: {
                action:'select_nomination',
                nomination_id:val,
                user_id:user_id
            },
            dataType: 'json',


            success: function (data) {
                console.log(data);

                $('.nominations_criteries').html(data.data)
                $('.nominations_criteries').append(data.msg)
            }
        });

    })


    $(document).on('submit', '.judge_admin_form',  function(e){
        e.preventDefault();

        $('.result').html(form_global.preloader)

        var data = $(this).serialize()

        $.ajax({
            type: 'post',
            url: form_global.url,
            data: data,
           // dataType: 'json',


            success: function (data) {
                console.log(data);

                $('.result').html('done')
            }
        });

    })


    $(document).on('click', '.set_score',  function(e){
        e.preventDefault();

        var score = $(this).closest('tr').find('select')
        var post_id = $(this).attr('data-post_id')
        var td = score.parent()
        if (!score.val()) {
            alert('You must set a score!')
            return
        }

        td.html(form_global.preloader)

        var data = $(this).serialize()

        $.ajax({
            type: 'post',
            url: form_global.url,
            data: {
                action: 'set_score',
                score: score.val(),
                post_id: post_id
            },
            dataType: 'json',


            success: function (data) {
                console.log(data);

                td.html(data.result)
            }
        });

    })





})