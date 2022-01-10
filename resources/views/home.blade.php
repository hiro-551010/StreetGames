@extends('users.header')


@section('header')
<div class="container">
    {{-- <form action="{{ route('winner') }}" method="POST"> --}}
        @csrf
        <div class="row">
            <div class="col-md-4">
                <table class="table-condensed" style="width:100%">
                    <tr>
                        <td class="col-md-5">
                            <div class="input-group">
                                <div class="form-control">Team 1</div>
                                <input class="align-bottom" type="radio" name="winner1" value="team1">
                            </div>
                        </td>
                        {{-- 二回戦目 --}}
                        <td class="col-md-5" rowspan="2">
                            <div class="input-group">
                                <div class="form-control">Team 1</div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="form-control">Team 2</div>
                                <input class="align-bottom" type="radio" name="winner1" value="team2">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-5">
                            <div class="input-group">
                                <div class="form-control">Team 3</div>
                                <input class="align-bottom" type="radio" name="winner2" value="team3">
                            </div>
                        </td>
                        {{-- 二回戦目 --}}
                        <td class="col-md-5" rowspan="2">
                            <div class="input-group">
                                <div class="form-control">Team 3</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="form-control">Team 4</div>
                                <input class="align-bottom" type="radio" name="winner2" value="team4">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <button type="submit">送信</button>
    </form>
</div>
@endsection


{{-- 
col = 列
row = 行 
--}}


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>

<div id="app">
    <example-component :test={{$host_tournament}} :players={{$players}}>

    </example-component>
</div>
<div id="app2">
    <winner-component :players={{$players}}></winner-component>

    
    <label><input type="radio" v-model="checkName" value="aaa">aaa</label>
    <label><input type="radio" v-model="checkName" value="bbb">bbb</label>
    <label><input type="radio" v-model="checkName" value="ccc">ccc</label>
    <p>@{{checkName}}</p>
</div>




<script src="{{ mix('js/app.js') }}"></script>
</body>
</html> --}}