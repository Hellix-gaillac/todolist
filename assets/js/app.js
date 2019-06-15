let vm = new Vue({
    el: '#app',
    data: {
        message: 'Salut les gens!',
        link: 'https://www.xavier-loup.fr/',
        cls: "success",
        persons: ['Xavier', 'Alice', 'Amandine', 'Daria', 'Camille', 'Marion', 'Robin']
    },
    methods: {
        add: function () {
            this.persons.push('Flush')
        }
    }
})