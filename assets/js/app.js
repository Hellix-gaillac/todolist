let message = {
    props: ['type', 'message'],
    template: `<div class="message success">{{message}}</div>`
}

let counter = {
    data: function () {
        return {
            count: 0
        }
    },
    methods: {
        increment: function () {
            this.count++
        }
    },
    template: `<div>
    <span>{{count}}</span>
    <button @click="increment()">Incrément</button>
    
    </div> `
}
let vm = new Vue({
    el: '#app',
    components: {
        message,
        counter
    },
    data: {
        message: 'Salut',

    },
    methods: {
        demo: function () {
            console.log('salut');

        }
    }


})