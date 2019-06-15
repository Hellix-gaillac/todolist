Vue.filter('capitalize', function(value){
    return value.toUpperCase()
})

Vue.directive('salut',{
    bind: function (el,binding,vnode){
        console.log(el,binding) 
    }
})


let vm = new Vue({
    el: '#app',
    data: {
        message: 'Jean',
        lastname: 'Petit',
        fullname:''

    },
    methods:{
        demo:function(){
            console.log('salut');
            
        }
    }
    

})