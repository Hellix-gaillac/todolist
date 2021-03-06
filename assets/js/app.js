let message = {
    props: {
        type: {
            type: String,
            default: 'success'
        },
        message: String,
        header: String
    },
    template: `<div class="message success">
    <i class="far fa-times-circle" @click.prevent="close"></i>
    <div class="header">{{header}}</div>
    {{message}}
    </div>`,
    methods: {
        close() {
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
    props: {
        start: {
            type: Number,
            default: 0
        }
    },
    methods: {
        increment: function () {
            this.count++
        }
    },
    template: `<div>
    <button @click="increment()">{{count}}</button>
    </div> `,
    mounted: function () {
        this.count = this.start
    }
}

let formUser = {
    props: {
        value: Object
    },
    data() {
        return {
            user: {
                ...this.value
            }
        }
    },
    methods: {
        save() {
            this.$emit('input', this.user)
        }
    },
    template: `
    <form @submit.prevent="save">
         <p><slot name="header"></slot></p>

        <div class="champs">
            <label for="">Prénom : </label><br/>
            <input type="text" v-model="user.firstname"/>
        </div>
        <div class="champs">
            <label for="">Nom : </label><br/>
            <input type="text"  v-model="user.lastname"/>
        </div>
        <button type="submit" >Valider</button>
        <p><slot name="footer"></slot></p>
    </form>
    `,
    mounted() {
        console.log(this)
    }

}
let vm = new Vue({
    el: '#app',
    components: {
        message,
        counter,
        formUser
    },
    data: {
        message: 'Salut je suis un test',
        alert: false,
        user: {
            firstname: 'Jean',
            lastname: 'Petit'
        }
    },
    methods: {
        showAlert() {
            this.alert = true
        },
        hideAlert() {
            this.alert = false
        }
    }


})