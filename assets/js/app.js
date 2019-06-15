let message = {
    props: {
        type :{type:String,default:'success'},
        message: String,
        header:String
    },
    template: `<div class="message success">
    <i class="far fa-times-circle" @click="close"></i>
    <div class="header">{{header}}</div>
    {{message}}
    </div>`,
    methods:{
        close(){
            this.$emit('close')

        }
    }
}

let counter = {
    data: function () {
        return {
            count: 0
        }
    },
    props:{
        start: {type : Number, default:0}
    },
    methods: {
        increment: function () {
            this.count++
        }
    },
    template: `<div>
    <button @click="increment()">{{count}}</button>
    </div> `,
    mounted: function(){
        this.count = this.start
    }
}
let vm = new Vue({
    el: '#app',
    components: {
        message,
        counter
    },
    data: {
        message: 'Salut',
        alert:false
    },
    methods: {
        showAlert () {
            this.alert=true
        },
        hideAlert () {
            this.alert=false
        }
    }


})