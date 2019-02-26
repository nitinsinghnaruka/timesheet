<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Time Sheet</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    
    </head>
    <body>
        <div id="app">
            <div class="container-fluid">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-4">
                        <div class="card rounded shadow text-center">
                            <div class="card-body">
                                <h4 class="card-title">Time</h4>
                                <h5 class="card-subtitle text-success font-weight-bold mb-2">@{{ currentTime }}</h5>
                                <h3 class="mb-3">@{{ logHours }}</h3>
                                <button type="button" class="btn btn-success" @click="startLogTime()" :disabled="counterRunning">Start</button>
                                <button type="button" class="btn btn-danger" @click="stopLogTime()" :disabled="! counterRunning">Stop</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card rounded shadow">
                            <div class="card-body">
                                <h4 class="card-title text-center">Calculate Time</h4>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <h3 class="text-center">@{{ calculatedHours }}</h3>

                                        <form type="POST" class="mt-3 text-center" @keypress="timeError = null;" @submit.prevent="addTime()">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter time" name="time" v-model="time" />
                                                <small id="timeHelp" class="form-text text-muted text-left">Time must be in 00:00 format.</small>
                                                <small id="timeHelp" class="form-text text-danger text-left" v-if="timeError">@{{ timeError }}</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div v-if="times.length">
                                            <ul class="list-group" style="overflow-x: auto; max-height: 200px;">
                                                <li class="list-group-item text-center p-2" v-for="(time, index) in times" :key="index">@{{ time }}</li>
                                            </ul>
                                            <div class="mt-2 text-center pl-2">
                                                <a href="#" class="card-link text-danger" @click.prevent="clearCalculatedHours()">Clear</a>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="text-center mt-5">No times.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
