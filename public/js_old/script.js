
let ComponentMessage = {
    data: function(){
        return {
            name: 'Mostafa',
            age: 33
        }
    },
    template: `<li class="list-group-item"><slot></slot></li>`
};


var app2 = new Vue({
    el: '#app-2',
    data: {
        message: '',
        chat: {
            message: []
        }
    },
    components: {
        'app-message': ComponentMessage
    },
    methods: {
        send: function(){
            if(this.message.length != 0) {
                this.chat.message.push(this.message);
                this.getChat();
            }
        },
        getChat: function(){
            console.log(this.chat);
        }
    }
});

