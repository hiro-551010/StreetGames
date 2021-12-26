{{-- @extends('users.header')


@section('header')

@endsection --}}



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
   

    
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-tournament-bracket@2.1.2/dist/vue-tournament-bracket.umd.min.js"></script>
<script src="{{asset('js/tournament.js')}}"></script>
    
<input type="button" onclick="hello()">

<div id="app">
    <p v-once>{{ message }}</p>
    <p v-text="message"></p>
    <p>{{ number }}</p>
    <!-- dataのokがtrueならyes, falseならno -->
    <p>{{ ok? 'YES': 'NO' }}</p>
    <p>{{ sayHi() }}</p> 
    <!-- v-bind:href=""と書けるが、下のように省略できる -->
    <a :href="googleurl">Google</a>   
    <a :[attributes]="googleurl">Google</a>
    <a v-bind="twitterobject">Twitter</a>
    
</div>

<script>
    new Vue({
        el: '#app',
        data: {
            message: "Hello World!",
            number: 3,
            ok: true,
            googleurl: 'https://google.com',
            attributes: 'href',
            twitterobject: {
                href: 'https://twitter.com', 
                id: 31,
            }
            
        },
        methods: {
            sayHi: function() {
                this.message = 'Hello VueJS'
                return this.message;
            }
        }
        }
    )
</script>



</body>
</html>