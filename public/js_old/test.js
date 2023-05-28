/* handle ajax request for create page  */
$(document).on('click', '.btn-modal', function(e) {
    e.preventDefault();
    const container = $(this).data('container');
    $.ajax({
        url: $(this).data('href'),
        dataType: 'html',
        success: function(result) {
            $(container).html(result).modal('show');
        }
    });
});


// variation template
$(document).on('click', '#add_variation_values', function() {
    var html =
        '<div class="form-group"><div class="col-sm-7 col-sm-offset-3"><input type="text" name="variation_values[]" class="form-control" required></div><div class="col-sm-2"><button type="button" class="btn btn-danger delete_variation_value">-</button></div></div>';
    $('#variation_values').append(html);
});
$(document).on('click', '.delete_variation_value', function() {
    $(this)
        .closest('.form-group')
        .remove();
});


    // // window.Vue = require('vue');
    // Vue.component('message',{
    //     template
    // })
    // Vue.component('app-message',{
    //     data: function(){
    //         return {
    //             name: 'mostafa',
    //             age: 20
    //         }
    //     },
    //     template: '<li>welcome para</li>'
    // });
    
    var ComponentMessage = {
        data: function(){
            return {
                name: 'mostafa',
                age: 20
            }
        },
        template: '<li>welcome para</li>'
    };
    
    console.log(ComponentMessage);
    // var app2 = new Vue({
    //     el: '#app-2',
    //     data: {
    //         message: ""
    //     },
    //     methods: {
    //         send: function(){
    //             if(this.message.length != 0) {
    //                 console.log(this.message);    
    //             }
    //         }
    //     },
    //     components: {
        
    //     }
    // });
        
    //     // app2.component('message',require('./components/message.vue'));